<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipantLog;
use App\Models\PointExchangeLog;
use App\Models\Product;
use App\Models\ProductDealLog;
use App\Models\Request;

//#82-主催したイベント情報
class MyPageController extends Controller
{
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
        $earned_product_deal_logs = ProductDealLog::notCancelled()->chargeable()->with(['product' => function ($query) {
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

    public function itemsListed()
    {
        $user = Auth::user();
        $lendable_products = Product::where('user_id', $user->id)
            ->availableProducts()
            ->with('productImages')
            ->with('productLikes')
            ->with('productTags.tag')
            ->get();

        $borrowed_products = Product::where('user_id', $user->id)
            ->occupiedAndDeliveringProducts()
            ->with('productImages')
            ->with('productLikes')
            ->with('productTags.tag')
            ->get();

        $applying_products = Product::where('user_id', $user->id)
            ->pendingProducts()
            ->with('productImages')
            ->with('productLikes')
            ->with('productTags.tag')
            ->get();

        return view('user.mypage.items-listed', compact('lendable_products', 'borrowed_products', 'applying_products'));
    }

    public function eventsOrganized()
    {
        $user = Auth::user();

        $before_held_events = Event::where('user_id', $user->id)
            ->where('completed_at', null)
            ->where('cancelled_at', null)
            ->with(['eventLikes', 'eventParticipants.user', 'eventTags.tag'])
            ->orderBy('created_at', 'desc')
            ->get();

        $after_held_events = Event::where('user_id', $user->id)
            ->where('completed_at', '!=', null)
            ->where('cancelled_at', null)
            ->with(['eventLikes', 'eventParticipants.user', 'eventTags.tag'])
            ->orderBy('created_at', 'desc')
            ->get();

        $cancelled_events = Event::where('user_id', $user->id)
            ->where('completed_at', null)
            ->where('cancelled_at', '!=', null)
            ->with(['eventLikes', 'eventParticipants.user', 'eventTags.tag'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.mypage.events-organized', compact('before_held_events', 'after_held_events', 'cancelled_events'));
    }

    public function eventsJoined()
    {
        $user = Auth::user();

        $before_held_joined_events = Event::whereHas('eventParticipants', function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('cancelled_at', null);
        })
            ->where('completed_at', null)
            ->where('cancelled_at', null)
            ->with('eventLikes', 'eventParticipants.user', 'eventTags.tag')
            ->orderBy('created_at', 'desc')
            ->get();

        $after_held_joined_events = Event::whereHas('eventParticipants', function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('cancelled_at', null);
        })
            ->where('completed_at', '!=', null)
            ->where('cancelled_at', null)
            ->with(['eventLikes', 'eventParticipants.user', 'eventTags.tag'])
            ->orderBy('created_at', 'desc')
            ->get();

        $cancelled_joined_events = Event::whereHas('eventParticipants', function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('cancelled_at', null);
        })
            ->where('completed_at', null)
            ->where('cancelled_at', '!=', null)
            ->with(['eventLikes', 'eventParticipants.user', 'eventTags.tag'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.mypage.events-joined', compact('before_held_joined_events', 'after_held_joined_events', 'cancelled_joined_events'));
    }

    public function eventsLiked()
    {
        $user = Auth::user();

        $liked_events = Event::whereHas('eventLikes', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with('eventLikes', 'eventParticipants.user', 'eventTags.tag')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.mypage.events-liked', compact('user', 'liked_events'));
    }

    public function requestsPosted()
    {
        $user = Auth::user();

        $resolved_requests = Request::where('user_id', $user->id)
            ->resolvedRequests()
            ->with('requestLikes')
            ->with('requestTags.tag')
            ->orderBy('created_at', 'desc')
            ->get()
            ->each(function ($request) {
                $request->type = $request->getRequestType($request->type_id);
            });

        $unresolved_requests = Request::where('user_id', $user->id)
            ->unresolvedRequests()
            ->with('requestLikes')
            ->with('requestTags.tag')
            ->orderBy('created_at', 'desc')
            ->get()
            ->each(function ($request) {
                $request->type = $request->getRequestType($request->type_id);
            });

        return view('user.mypage.requests-posted', compact('resolved_requests', 'unresolved_requests'));
    }

    public function requestsLiked()
    {
        $user = Auth::user();

        $liked_requests = Request::whereHas('requestLikes', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with(['requestTags.tag', 'requestLikes'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->each(function ($request) {
                $request->type = $request->getRequestType($request->type_id);
            });

        $product_request_type_id = Request::PRODUCT_REQUEST_TYPE_ID;

        return view('user.mypage.requests-liked', compact('liked_requests', 'user', 'product_request_type_id'));
    }
}
