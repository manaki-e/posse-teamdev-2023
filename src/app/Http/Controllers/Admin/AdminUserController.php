<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipantLog;
use App\Models\Product;
use App\Models\ProductDealLog;
use App\Models\Request as AppRequest;
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
        $joined_event_logs = EventParticipantLog::where('user_id', $user)->with('event.eventTags.tag')->paginate(10);
        $held_events = Event::where('user_id', $user)->with('participants')->withSum('participants', 'point')->withCount('participants')->paginate(10);
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
