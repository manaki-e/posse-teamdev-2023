<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipantLog;
use App\Models\Product;
use App\Models\ProductDealLog;
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
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $user_data = User::with('department')->findOrFail($user);
        $product_deal_logs = ProductDealLog::UserInvolved($user)->with('user')->paginate(10);
        $products = Product::approvedProducts()->where('user_id', $user)->with('productTags.tag')->withCount('productLikes')->paginate(10);
        $held_events = Event::where('user_id', $user)->with('participants')->withSum('participants', 'point')->get();
        // print_r('主催イベント<br>');
        // foreach ($held_events as $held_event) {
        //     print_r('タイトル->' . $held_event->title);
        //     foreach ($held_event->eventParticipants as $event_participant) {
        //         print_r('名前->' . $event_participant->user->name);
        //     }
        //     print_r('ポイント合計->' . $held_event->event_participants_sum_point);
        //     print_r('日時->' . $held_event->date->format('Y年m月d日 H時i分s秒'));
        //     print_r('<br>');
        // }
        // print_r('参加イベント<br>');
        $joined_events = EventParticipantLog::where('user_id', $user)->with('event')->get();
        // foreach ($joined_events as $joined_event) {
        //     print_r('タイトル->' . $joined_event->event->title);
        //     print_r('ポイント->' . $joined_event->point);
        //     print_r('日時->' . $joined_event->event->date->format('Y年m月d日 H時i分s秒'));
        //     print_r('<br>');
        // }

        return view('admin.users.detail', compact('user', 'user_data', 'product_deal_logs', 'products' , 'held_events', 'joined_events'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        //
    }
}
