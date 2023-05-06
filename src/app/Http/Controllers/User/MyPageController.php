<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\EventParticipantLog;
use App\Models\Event_participants;
use App\Http\Controllers\Controller;
use App\Models\PointExchangeLog;
use App\Models\ProductDealLog;
use Illuminate\Http\Request;

//#82-主催したイベント情報
class MyPageController extends Controller
{
    // イベントID
    public function eventsOrganized()
    {
        // Authのid
        $auth_id = Auth::id();
        //Authのidに紐づいているテーブルを全部取得
        $event_organizes = Event::with('participants')->where('user_id', '=', $auth_id)->with('event')->get();
        foreach ($event_organizes as $event_organize) {
            print_r($event_organize->title . '<br>');
            print_r($event_organize->created_at . '<br>');
            print_r($event_organize->completed_at . '<br>');
        }
        $earned_points = Event::where('user_id', $auth_id)->with('participants')->withSum('participants', 'point')->get();
        foreach ($earned_points as $earned_point) {
            print_r($earned_point->participants_sum_point);
        }
        dd();
        // return view();
    }

    #81-参加したイベント情報
    public function eventsJoined()
    {
        $auth_id = Auth::id();
        $event_joins = EventParticipantLog::where('user_id', $auth_id)->get();
        foreach ($event_joins as $event_join) {
            print_r($event_join->event->title . '<br>');
            print_r($event_join->point . '<br>');
            print_r($event_join->user->name . '<br>');
        }
    }
    public function points()
    {
        $user = Auth::user();
        $earned_point = $user->earned_point;
        $distribution_point = $user->distribution_point;
        print_r('換金可能' . $earned_point . '換金不可能' . $distribution_point);
        dd();
        return view('user.mypage.points', compact('earned_point', 'distribution_point'));
    }
    public function profile()
    {
        $user = Auth::user();
        $icon = $user->icon;
        $description = $user->description;
        print_r('アイコンファイル名' . $icon . '自己紹介' . $description);
        dd();
        return view('user.mypage.profile', compact('icon', 'description'));
    }
    public function pointHistory()
    {
        //消費と獲得に分ける
        //内容：カテゴリ（イベント、アイテム、換金）、内容（イベント名、アイテム名、換金）、日時、ポイント
        //消費=>product_deal_logsとevent_participant_logsを結合
        $user = Auth::user();
        $distribution_product_deal_logs = $user->productDealLogs()->with('product')->get()->map(function ($product_deal_log) {
            return [
                'category' => 'アイテム借入',
                'name' => $product_deal_log->product->title,
                'created_at' => $product_deal_log->created_at->format('Y/m/d'),
                'point' => -$product_deal_log->product->point,
            ];
        });
        $distribution_event_participant_logs = $user->eventParticipantLogs()->with('event')->get()->map(function ($event_participant_log) {
            return [
                'category' => 'イベント参加',
                'name' => $event_participant_log->event->title,
                'created_at' => $event_participant_log->created_at->format('Y/m/d'),
                'point' => -$event_participant_log->point,
            ];
        });
        //バグ発生対策
        $distribution_event_participant_logs = collect($distribution_event_participant_logs);
        $distribution_product_deal_logs = collect($distribution_product_deal_logs);
        $distribution_point_logs = $distribution_product_deal_logs->merge($distribution_event_participant_logs)->sortByDesc('created_at');
        //獲得=>point_exchange_logsとevents->withsum()とproduct_deal_logsを結合
        //換金申請が承認されるタイミングでポイントが減る設計
        $earned_point_exchange_logs = $user->pointExchangeLogs()->where('point_exchange_logs.status', PointExchangeLog::STATUS['APPROVED'])->get()->map(function ($point_exchange_log) {
            return [
                'category' => '換金',
                'name' => '換金',
                'created_at' => $point_exchange_log->created_at->format('Y/m/d'),
                'point' => -$point_exchange_log->point,
            ];
        });
        $earned_event_logs = $user->events()->withSum('participants', 'point')->get()->map(function ($event) {
            return [
                'category' => 'イベント主催',
                'name' => $event->title,
                'created_at' => $event->completed_at->format('Y/m/d'),
                'point' => $event->participants_sum_point,
            ];
        });
        $earned_product_deal_logs = ProductDealLog::with('product')->whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get()->map(function ($product_deal_log) {
            return [
                'category' => 'アイテム貸出',
                'name' => $product_deal_log->product->title,
                'created_at' => $product_deal_log->created_at->format('Y/m/d'),
                'point' => $product_deal_log->product->point,
            ];
        });
        //バグ発生対策
        $earned_event_logs = collect($earned_event_logs);
        $earned_product_deal_logs = collect($earned_product_deal_logs);
        $earned_point_exchange_logs = collect($earned_point_exchange_logs);
        $earned_point_logs = $earned_point_exchange_logs->merge($earned_event_logs)->merge($earned_product_deal_logs)->sortByDesc('created_at');
        dd('配布ポイントの変動', $distribution_point_logs, '獲得ポイントの変動', $earned_point_logs);
        return view('user.mypage.point_history', compact('earned_point_logs', 'distribution_point_logs'));
    }
}