<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipantLog;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('department')->paginate(10);

        return view('admin.users.index', compact('users'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_profile = User::with('department')->findOrFail($id);
        $product_japanese_status = Product::JAPANESE_STATUS;
        print_r('ユーザー詳細<br>');
        print_r($user_profile->name);
        print_r($user_profile->email);
        print_r($user_profile->slack);
        print_r($user_profile->department->name);
        print_r($user_profile->earned_point);
        print_r($user_profile->distribution_point);
        print_r('<br>');
        $held_events = Event::where('user_id', $id)->with('participants')->withSum('participants', 'point')->get();
        print_r('主催イベント<br>');
        foreach ($held_events as $held_event) {
            print_r('タイトル->' . $held_event->title);
            foreach ($held_event->eventParticipants as $event_participant) {
                print_r('名前->' . $event_participant->user->name);
            }
            print_r('ポイント合計->' . $held_event->event_participants_sum_point);
            print_r('日時->' . $held_event->date->format('Y年m月d日 H時i分s秒'));
            print_r('<br>');
        }
        print_r('参加イベント<br>');
        $joined_events = EventParticipantLog::where('user_id', $id)->with('event')->get();
        foreach ($joined_events as $joined_event) {
            print_r('タイトル->' . $joined_event->event->title);
            print_r('ポイント->' . $joined_event->point);
            print_r('日時->' . $joined_event->event->date->format('Y年m月d日 H時i分s秒'));
            print_r('<br>');
        }
        $approved_products = Product::approvedProducts()->where('user_id', $id)->with('deals.user')->get()->map(function ($approved_product) use ($product_japanese_status) {
            $approved_product->japanese_status = $product_japanese_status[$approved_product->status];
            if ($approved_product->japanese_status === '貸出中') {
                $approved_product->currently_borrowing_user = $approved_product->deals->last()->user->name;
            } else {
                $approved_product->currently_borrowing_user = null;
            }
            return $approved_product;
        });
        print_r('登録済みアイテム一覧<br>');
        foreach ($approved_products as $approved_product) {
            print_r('タイトル->' . $approved_product->title);
            print_r('ポイント->' . $approved_product->point);
            print_r('ステータス->' . $approved_product->japanese_status);
            print_r('現在借りてる人' . $approved_product->currently_borrowing_user);
            print_r('<br>');
        }
        dd();
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
