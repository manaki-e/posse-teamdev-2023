<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Event;
use App\Models\EventParticipantLog;
use App\Models\Product;
use App\Models\ProductDealLog;
use App\Models\Request as AppRequest;
use App\Models\Setting;
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
        $users = User::with('department')->orderBy('email', 'asc')->paginate(10, ['*'], 'users');

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
        $product_occupied_status = Product::STATUS['occupied'];
        $product_delivering_status = Product::STATUS['delivering'];
        $joined_event_logs = EventParticipantLog::where('user_id', $user)->with('event.eventTags.tag')->paginate(10);
        $held_events = Event::where('user_id', $user)->with('eventParticipantLogs')->withSum('eventParticipantLogs', 'point')->withCount(['eventParticipantLogs' => function ($query) {
            $query->where('cancelled_at', null);
        }])->paginate(10);
        $requests = AppRequest::where('user_id', $user)->with('product')->with('event')->paginate(10);

        $total_earned_points_by_events = Event::getSumOfEarnedPoints($user);
        $total_earned_points_by_products = Product::getSumOfEarnedPoints($user);
        $total_earned_points = $total_earned_points_by_events + $total_earned_points_by_products;

        $total_used_points_by_events = EventParticipantLog::getSumOfUsedPoints($user);
        $total_used_points_by_products = ProductDealLog::getSumOfUsedPoints($user);
        $total_used_points = $total_used_points_by_events + $total_used_points_by_products;

        $current_month_earned_points_by_events = Event::getSumOfEarnedPointsCurrentMonth($user);
        $current_month_earned_points_by_products = Product::getSumOfEarnedPointsCurrentMonth($user);
        $current_month_earned_points = $current_month_earned_points_by_events + $current_month_earned_points_by_products;

        $current_month_used_points = Setting::monthlyDistributionPoint() - $user_data->distribution_point;
        return view('admin.users.detail', compact('user', 'user_data', 'product_deal_logs', 'products', 'joined_event_logs', 'held_events', 'requests', 'total_earned_points', 'total_used_points', 'current_month_earned_points', 'current_month_used_points', 'product_occupied_status', 'product_delivering_status'));
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
        $user_instance = User::findOrFail($user);
        $admin_user_count = User::where('is_admin', 1)->count();

        if ($admin_user_count === 1 && $user_instance->is_admin === 1) {
            return Redirect::route('admin.users.index')->with(['flush.message' => '管理者は最低一人必要です', 'flush.alert_type' => 'error']);
        } elseif ($user_instance->is_admin === 1) {
            $user_instance->is_admin = 0;
        } elseif ($user_instance->is_admin === 0) {
            $user_instance->is_admin = 1;
        }
        $user_instance->save();
        //ログインしている管理者が自分を一般ユーザーに変更した場合はログアウトさせる
        if (auth()->user()->id === $user_instance->id) {
            auth()->logout();
            return Redirect::route('login');
        } else {
            return Redirect::route('admin.users.index')->with(['flush.message' => '権限の変更が正しく行われました', 'flush.alert_type' => 'success']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        $user_instance = User::findOrFail($user);
        $admin_user_count = User::where('is_admin', 1)->count();
        if ($admin_user_count === 1 && $user_instance->is_admin === 1) {
            return Redirect::route('admin.users.index')->with(['flush.message' => '管理者は最低一人必要です', 'flush.alert_type' => 'error']);
        } else {
            $user_instance->delete();
        }
        // ユーザテーブルに紐づく各テーブルのデータも削除する
        if (auth()->user()->id === $user) {
            return Redirect::route('login');
        } else {
            return Redirect::route('admin.users.index')->with(['flush.message' => 'ユーザ削除が正しく行われました', 'flush.alert_type' => 'success']);
        }
    }
}
