<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Event;
use App\Models\EventParticipantLog;
use App\Models\Product;
use App\Models\ProductDealLog;
use App\Models\Request as AppRequest;
use App\Models\SlackUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('department')->orderBy('email', 'asc')->paginate(10, ['*'], 'users')->appends(['slack_users' => request('slack_users')]);

        $unauthenticated_users = SlackUser::unauthenticated()->orderBy('email', 'asc')->paginate(10, ['*'], 'slack_users')->appends(['users' => request('users')]);

        return view('admin.users.index', compact('users', 'unauthenticated_users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request->department_name)) {
            $department_id = null;
        } else {
            $department = Department::firstOrCreate(['name' => $request->department_name]);
            $department_id = $department->id;
        }
        $user_instance = new User();
        $user_instance->name = $request->name;
        $user_instance->display_name = $request->display_name;
        $user_instance->email = $request->email;
        $user_instance->password = Hash::make(Str::random(10));
        $user_instance->icon = $request->icon;
        $user_instance->slackID = $request->slackID;
        $user_instance->is_admin = 0;
        $user_instance->department_id = $department_id;
        $user_instance->created_at = now();
        $user_instance->save();

        return Redirect::route('admin.users.index')->with(['flush.message' => 'slackにいるユーザを新しくPeerPerkユーザとして登録しました', 'flush.alert_type' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $user_data = User::with('department')->findOrFail($user);
        $product_deal_logs = ProductDealLog::UserInvolved($user)->with('user')->paginate(10);
        $products = Product::approvedProducts()->where('user_id', $user)->with('productTags.tag')->withCount('productLikes')->paginate(10);
        $joined_event_logs = EventParticipantLog::where('user_id', $user)->with('event.eventTags.tag')->paginate(10);
        $held_events = Event::where('user_id', $user)->with('eventParticipants')->withSum('participants', 'point')->withCount('participants')->paginate(10);
        $requests = AppRequest::where('user_id', $user)->with('product')->with('event')->paginate(10);

        return view('admin.users.detail', compact('user', 'user_data', 'product_deal_logs', 'products', 'joined_event_logs', 'held_events', 'requests'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        // 管理者権限に変更する
        $user_instance = User::findOrFail($user);
        if ($user_instance->is_admin === 1) {
            $user_instance->is_admin = 0;
        } elseif ($user_instance->is_admin === 0) {
            $user_instance->is_admin = 1;
        }
        $user_instance->save();

        // 後ほどここでチャンネルへ招待するメソッドを呼び出す

        return Redirect::route('admin.users.index')->with(['flush.message' => '管理者権限の付与が正しく行われました', 'flush.alert_type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        User::findOrFail($user)->delete();
        // ユーザテーブルに紐づく各テーブルのデータも削除する

        return Redirect::route('admin.users.index')->with(['flush.message' => 'ユーザ削除が正しく行われました', 'flush.alert_type' => 'success']);
    }
}
