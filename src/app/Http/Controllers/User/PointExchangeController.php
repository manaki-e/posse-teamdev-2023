<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SlackController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\PointExchangeLog;

class PointExchangeController extends Controller
{
    public function __construct(SlackController $slackController)
    {
        $this->slackController = $slackController;
        $this->slackAdminChannelId = $slackController->searchChannelId('peerperk管理者', true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        return view('backend_test.point-exchange', compact('user'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->point = (int)$request->point;

        // ログインユーザーのポイント足りるかチェック
        if ($user->earned_point >= $request->point) {
            // ポイントを減らす
            $user->earned_point -= $request->point;
            $user->save();
            // point_exchange_logsテーブルに追加される
            $point_exchange_instance = new PointExchangeLog();
            $point_exchange_instance->user_id = $user->id;
            $point_exchange_instance->point = $request->point;
            $point_exchange_instance->status = PointExchangeLog::STATUS['PENDING'];
            $point_exchange_instance->save();
            //slack登録申請者
            $this->slackController->sendNotification($user->slackID, 'ポイント交換申請を行いました。');
            //slack管理者
            $this->slackController->sendNotification($this->slackAdminChannelId, "<@".$user->slackID.">より、ポイントの交換申請を受け付けました。\n```".env('APP_URL')."admin/point-exchanges```");
            // redirect backする
            return redirect()->back()->with(['flush.message' => 'ポイント交換申請完了しました。', 'flush.alert_type' => 'success']);
        } else {
            //ポイントが足りないエラーメッセージ
            return redirect()->back()->with('error', 'ポイントが不足しています。');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function updateApproved(Request $request, $id)
    {
        $point_exchange_log = PointExchangeLog::findOrFail($id);
        $point_exchange_log->status = PointExchangeLog::STATUS['APPROVED'];
        $point_exchange_log->save();
        //slack登録申請者
        $this->slackController->sendNotification($point_exchange_log->user->slackID, '管理者がポイント交換申請を完了しました。（もしAmazon Gifhカードをまだ受け取っていないようでしたら、管理者にお知らせください。）');
        //slack管理者
        $this->slackController->sendNotification($this->slackAdminChannelId, "<@".$point_exchange_log->user->slackID.">のポイント交換を完了しました。");
        return redirect()->route('admin.point-exchanges')->with(['flush.message' => '交換完了処理が正しく行われました', 'flush.alert_type' => 'success']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
