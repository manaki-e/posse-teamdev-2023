<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SlackController;
use App\Models\Department;
use App\Models\Event;
use App\Models\EventParticipantLog;
use App\Models\Product;
use App\Models\ProductDealLog;
use App\Models\Request as AppRequest;
use App\Models\Setting;
use App\Models\SlackUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


class AdminUserController extends Controller
{
    public function __construct(SlackController $slackController)
    {
        $this->slackController = $slackController;
    }

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
        // 一度削除したユーザであった場合は復元する（データは消されているためポイントのデータのみ復元される）
        $user = User::withTrashed()->where('email', $request->email)->first();
        if ($user->trashed()) {
            $user->restore();
            return Redirect::route('admin.users.index')->with(['flush.message' => 'slackにいるユーザを新しくPeerPerkユーザとして登録しました', 'flush.alert_type' => 'success']);
        }

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
        $product_occupied_status = Product::STATUS['occupied'];
        $product_delivering_status = Product::STATUS['delivering'];
        $joined_event_logs = EventParticipantLog::where('user_id', $user)->with('event.eventTags.tag')->paginate(10);
        $held_events = Event::where('user_id', $user)->with('eventParticipants')->withSum('eventParticipants', 'point')->withCount(['eventParticipants' => function ($query) {
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
        $channel_id = $this->slackController->searchChannelId("peerperk管理者", true);
        $user_slack_id = $user_instance->slackID;
        $admin_user_count = User::where('is_admin', 1)->count();
        
        if ($admin_user_count === 1 && $user_instance->is_admin === 1) {
            return Redirect::route('admin.users.index')->with(['flush.message' => '管理者は最低一人必要です', 'flush.alert_type' => 'error']);
        } elseif ($user_instance->is_admin === 1) {
            $user_instance->is_admin = 0;
            $this->slackController->removeUserFromChannel($channel_id, $user_slack_id);
        } elseif ($user_instance->is_admin === 0) {
            $user_instance->is_admin = 1;
            $this->slackController->inviteUsersToChannel($channel_id, $user_slack_id);
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
        User::findOrFail($user)->delete();
        // ユーザテーブルに紐づく各テーブルのデータも削除する
        if (auth()->user()->id === $user) {
            return Redirect::route('login');
        } else {
            return Redirect::route('admin.users.index')->with(['flush.message' => 'ユーザ削除が正しく行われました', 'flush.alert_type' => 'success']);
        }
    }
}
