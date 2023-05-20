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
        $event_organizes = Event::with('eventParticipants')->where('user_id', '=', $auth_id)->with('event')->get();
        foreach ($event_organizes as $event_organize) {
            print_r($event_organize->title . '<br>');
            print_r($event_organize->created_at . '<br>');
            print_r($event_organize->completed_at . '<br>');
        }
        $earned_points = Event::where('user_id', $auth_id)->with('eventParticipants')->withSum('eventParticipants', 'point')->get();
        foreach ($earned_points as $earned_point) {
            print_r($earned_point->event_participants_sum_point);
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
        dd();
        return view('user.mypage.profile', compact('user'));
    }
    public function pointHistory()
    {
        //消費と獲得に分ける
        //内容：カテゴリ（イベント、アイテム、換金）、内容（イベント名、アイテム名、換金）、日時、ポイント
        //消費=>product_deal_logsとevent_participant_logsを結合
        //消費はキャンセル関係なくポイントが減るためwithTrashed()
        $unchargeable_month_count = ProductDealLog::UNCHARGEABLE_MONTH_COUNT;
        $user = Auth::user();
        $distribution_product_deal_logs = ProductDealLog::where('user_id', $user->id)->chargeable()->with(['product' => function ($query) {
            $query->withTrashed();
        }])->get()->map(function ($product_deal_log) use ($unchargeable_month_count) {
            if ($product_deal_log->month_count === $unchargeable_month_count - 1) {
                //借りた最初の月
                return [
                    'name' => $product_deal_log->product->title,
                    'created_at' => $product_deal_log->created_at,
                    'point' => -$product_deal_log->point,
                ];
            } else {
                //借りた最初の月と差し引き不可能な月以外
                return [
                    'name' => $product_deal_log->product->title . ($product_deal_log->created_at->subMonth()->format('(n月分)')),
                    'created_at' => $product_deal_log->created_at,
                    'point' => -$product_deal_log->point,
                ];
            }
        });
        $distribution_event_participant_logs = EventParticipantLog::withTrashed()->where('user_id', $user->id)->with(['event' => function ($query) {
            $query->withTrashed();
        }])->get()->map(function ($event_participant_log) {
            return [
                'name' => $event_participant_log->event->title,
                'created_at' => $event_participant_log->created_at,
                'point' => -$event_participant_log->point,
            ];
        });
        //バグ発生対策
        $distribution_event_participant_logs = collect($distribution_event_participant_logs);
        $distribution_product_deal_logs = collect($distribution_product_deal_logs);
        $distribution_point_logs = $distribution_product_deal_logs->merge($distribution_event_participant_logs)->sortByDesc('created_at')->map(function ($distribution_point_log) {
            $distribution_point_log['created_at'] = $distribution_point_log['created_at']->format('Y-m-d');
            return $distribution_point_log;
        });
        //獲得=>point_exchange_logsとevents->withsum()とproduct_deal_logsを結合
        $earned_point_exchange_logs = PointExchangeLog::where('user_id', $user->id)->get()->map(function ($point_exchange_log) {
            return [
                'name' => '換金申請',
                'created_at' => $point_exchange_log->created_at,
                'point' => -$point_exchange_log->point,
            ];
        });
        $earned_event_logs = Event::where('user_id', $user->id)->where('completed_at', '!=', null)->withSum('eventParticipants', 'point')->get()->map(function ($event) {
            return [
                'name' => $event->title,
                'created_at' => $event->completed_at,
                'point' => $event->event_participants_sum_point,
            ];
        });
        //productが削除されてもポイントの変動は残る、product_deal_logが削除＝キャンセルされた場合はポイントの変動も削除
        $earned_product_deal_logs = ProductDealLog::notCanceled()->chargeable()->with(['product' => function ($query) {
            $query->withTrashed();
        }])->whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id)->withTrashed();
        })->get()->map(function ($product_deal_log) {
            return [
                'name' => $product_deal_log->product->title,
                'created_at' => $product_deal_log->created_at,
                'point' => $product_deal_log->point,
            ];
        });
        //バグ発生対策
        $earned_event_logs = collect($earned_event_logs);
        $earned_product_deal_logs = collect($earned_product_deal_logs);
        $earned_point_exchange_logs = collect($earned_point_exchange_logs);
        $earned_point_logs = $earned_point_exchange_logs->merge($earned_event_logs)->merge($earned_product_deal_logs)->sortByDesc('created_at')->map(function ($earned_point_log) {
            $earned_point_log['created_at'] = $earned_point_log['created_at']->format('Y-m-d');
            return $earned_point_log;
        });
        dd('配布ポイントの変動', $distribution_point_logs, '獲得ポイントの変動', $earned_point_logs);
        return view('user.mypage.point_history', compact('earned_point_logs', 'distribution_point_logs'));
    }
    public function requests()
    {
        $user = Auth::user();
        $requests = $user->requests()->with('requestTags.tag')->get()->map(function ($request) {
            $request->type = $request->getRequestType($request->type_id);
            return $request;
        });
        dd($requests);
        return view('user.mypage.requests', compact('requests'));
    }
    public function deals()
    {
        $user = Auth::user();
        $product_deal_logs = $user->productDealLogs()->with('product.user', 'product.productImages')->get();
        dd($product_deal_logs);
        return view('user.mypage.deals', compact('product_deal_logs'));
    }
    public function items()
    {
        $user = Auth::user();
        $available_products = $user->products()->availableProducts()->with('productImages')->get();
        $occupied_products = $user->products()->occupiedProducts()->with('productImages')->with('productDealLogs.user', function ($query) {
            //一番最後のレコード==今借りてる人
            $query->latest()->take(1);
        })->get();
        dd($occupied_products);
        return view('user.mypage.items', compact('available_products', 'occupied_products'));
    }
}