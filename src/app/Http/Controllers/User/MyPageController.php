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
use App\Models\Request as ModelsRequest;
use App\Models\User;


//#82-主催したイベント情報
class MyPageController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $user_id = $user->id;
        // アイテム
        $japanese_product_statuses = Product::JAPANESE_STATUS;
        unset($japanese_product_statuses[1]);
        $products = Product::where('user_id', $user->id)->approvedProducts()->withRelations()->get()->map(function ($product) use ($japanese_product_statuses) {
            $product->data_tag = '[' . implode(',', $product->productTags->pluck('tag_id')->toArray()) . ']';
            //配送中は貸出中として表示
            if ($product->status === Product::STATUS['delivering']) {
                $product->japanese_status = $japanese_product_statuses[Product::STATUS['occupied']];
                $product->status = Product::STATUS['occupied'];
            } else {
                $product->japanese_status = $japanese_product_statuses[$product->status];
            }
            if ($product->productLikes->contains('user_id', Auth::id())) {
                $product->isLiked = 1;
            } else {
                $product->isLiked = 0;
            }
            $product->description = $product->changeDescriptionReturnToBreakTag($product->description);
            return $product;
        })->sortByDesc('created_at');

        // イベント
        $events = Event::where('user_id', $user->id)->withCount('eventLikes')->withCount(['eventParticipants' => function ($query) {
            $query->where('cancelled_at', null);
        }])->with(['user', 'eventTags.tag', 'eventLikes.user'])->with(['eventParticipants' => function ($query) {
            $query->where('cancelled_at', null)->with('user');
        }])->get()->map(function ($event) use ($user_id) {
            $event->isLiked = $event->eventLikes->contains('user_id', $user_id);
            $event->isParticipated = $event->eventParticipants->contains('user_id', $user_id);
            if (empty($event->completed_at)) {
                $event->isCompleted = Event::COMPLETED_STATUSES[0];
            } else {
                $event->isCompleted = Event::COMPLETED_STATUSES[1];
            }
            $event->data_tag = '[' . implode(',', $event->eventTags->pluck('tag_id')->toArray()) . ']';
            $event->description = $event->changeDescriptionReturnToBreakTag($event->description);
            if ($event->eventLikes->contains('user_id', Auth::id())) {
                $event->isLiked = 1;
            } else {
                $event->isLiked = 0;
            }
            return $event;
        })->sortByDesc('created_at');

        // リクエスト
        $event_request_type_id = ModelsRequest::EVENT_REQUEST_TYPE_ID;
        $product_request_type_id = ModelsRequest::PRODUCT_REQUEST_TYPE_ID;
        $app = [
            $product_request_type_id => ['color' => 'text-blue-400', 'name' => 'Peer Product Share', 'japanese_name' => 'アイテム'],
            $event_request_type_id => ['color' => 'text-pink-600', 'name' => 'Peer Event', 'japanese_name' => 'イベント']
        ];
        $requests = ModelsRequest::where('user_id', $user->id)->with(['user', 'requestTags.tag'])->withCount('requestLikes')->orderBy('created_at', 'desc')->unresolvedRequests()->get()->map(function ($request) {
            $request->description = $request->changeDescriptionReturnToBreakTag($request->description);
            $request->data_tag = '[' . implode(',', $request->requestTags->pluck('tag_id')->toArray()) . ']';
            if ($request->requestLikes->contains('user_id', Auth::id())) {
                $request->isLiked = 1;
            } else {
                $request->isLiked = 0;
            }
            return $request;
        });

        return view('user.mypage.profile', compact('user', 'products', 'japanese_product_statuses', 'events', 'requests', 'app', 'event_request_type_id', 'product_request_type_id'));
    }

    public function account()
    {
        $user = Auth::user();
        return view('user.mypage.account', compact('user'));
    }

    public function pointHistory()
    {
        $user_id = Auth::id();

        $distribution_product_deal_logs = ProductDealLog::getUserChargeableProductDealLogsIncludingTrashedProduct($user_id)->map(function ($product_deal_log) {
            return $product_deal_log->formatProductDealLogForMyPageDistributionPointHistory();
        });
        $distribution_event_participant_logs = EventParticipantLog::getUserEventParticipantLogsIncludingTrashedEvent($user_id)->map(function ($event_participant_log) {
            return $event_participant_log->formatEventParticipantLogForMyPageDistributionPointHistory();
        });
        $distribution_point_logs = collect([$distribution_product_deal_logs, $distribution_event_participant_logs])->flatten(1)->sortByDesc('created_at');

        $earned_point_exchange_logs = PointExchangeLog::getUserPointExchangeLogs($user_id)->map(function ($point_exchange_log) {
            return $point_exchange_log->formatPointExchangeLogForMyPageEarnedPointHistory();
        });
        $earned_event_logs = Event::getUserEventsWithPointSum($user_id)->map(function ($event) {
            return $event->formatEventForMyPageEarnedPointHistory();
        });
        $earned_product_deal_logs = ProductDealLog::getUserEarnableProductDealLogsIncludingTrashedProduct($user_id)->map(function ($product_deal_log) {
            return $product_deal_log->formatProductDealLogForMyPageEarnedPointHistory();
        });
        $earned_point_logs = collect([$earned_point_exchange_logs, $earned_event_logs, $earned_product_deal_logs])->flatten(1)->sortByDesc('created_at');
        
        return view('user.mypage.point-history', compact('earned_point_logs', 'distribution_point_logs'));
    }

    public function itemsListed()
    {
        $user = Auth::user();
        $lendable_products = Product::where('user_id', $user->id)
            ->availableProducts()
            ->with('productImages', 'productLikes', 'productTags.tag')
            ->orderBy('created_at', 'desc')
            ->get();

        $borrowed_products = Product::where('user_id', $user->id)
            ->occupiedAndDeliveringProducts()
            ->with('productImages', 'productLikes', 'productTags.tag')
            ->orderBy('created_at', 'desc')
            ->get();

        $applying_products = Product::where('user_id', $user->id)
            ->pendingProducts()
            ->with('productImages', 'productLikes', 'productTags.tag')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.mypage.items-listed', compact('lendable_products', 'borrowed_products', 'applying_products'));
    }

    public function itemsBorrowed()
    {
        $user = Auth::user();
        $borrowed_products = Product::whereHas('productDealLogs', function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('returned_at', null)->where('cancelled_at', null);
        })
            ->with('productImages', 'productLikes', 'productTags.tag')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.mypage.items-borrowed', compact('borrowed_products'));
    }

    public function itemsLiked()
    {
        $user = Auth::user();

        $liked_products = Product::whereHas('productLikes', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with('productImages', 'productLikes', 'productTags.tag')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.mypage.items-liked', compact('liked_products'));
    }

    public function itemsHistory()
    {
        $user = Auth::user();

        $lend_product_histories = ProductDealLog::whereHas('product', function ($query) use ($user) {
            $query->withTrashed()->where('user_id', $user->id);
        })
            ->with('product.productImages', 'product.productTags.tag', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        $borrow_product_histories = ProductDealLog::where('user_id', $user->id)
            ->with(['product' => function ($query) {
                $query->withTrashed();
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.mypage.items-history', compact('lend_product_histories', 'borrow_product_histories'));
    }

    public function eventsOrganized()
    {
        $user = Auth::user();

        $before_held_events = Event::where('user_id', $user->id)
            ->where('completed_at', null)
            ->where('cancelled_at', null)
            ->withCount(['eventParticipants' => function ($query) {
                $query->where('cancelled_at', null);
            }])->with(['eventParticipants' => function ($query) {
                $query->where('cancelled_at', null)->with('user');
            }])
            ->with(['eventLikes', 'eventTags.tag'])
            ->orderBy('created_at', 'desc')
            ->get();

        $after_held_events = Event::where('user_id', $user->id)
            ->where('completed_at', '!=', null)
            ->where('cancelled_at', null)
            ->withCount(['eventParticipants' => function ($query) {
                $query->where('cancelled_at', null);
            }])->with(['eventParticipants' => function ($query) {
                $query->where('cancelled_at', null)->with('user');
            }])
            ->with(['eventLikes', 'eventTags.tag'])
            ->orderBy('created_at', 'desc')
            ->get();

        $cancelled_events = Event::where('user_id', $user->id)
            ->where('completed_at', null)
            ->where('cancelled_at', '!=', null)
            ->withCount(['eventParticipants' => function ($query) {
                $query->where('cancelled_at', null);
            }])->with(['eventParticipants' => function ($query) {
                $query->where('cancelled_at', null)->with('user');
            }])
            ->with(['eventLikes', 'eventTags.tag'])
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
            ->withCount(['eventParticipants' => function ($query) {
                $query->where('cancelled_at', null)->with('user');
            }])
            ->with('eventLikes', 'eventTags.tag')
            ->orderBy('created_at', 'desc')
            ->get();

        $after_held_joined_events = Event::whereHas('eventParticipants', function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('cancelled_at', null);
        })
            ->where('completed_at', '!=', null)
            ->where('cancelled_at', null)
            ->withCount(['eventParticipants' => function ($query) {
                $query->where('cancelled_at', null)->with('user');
            }])
            ->with(['eventLikes', 'eventTags.tag'])
            ->orderBy('created_at', 'desc')
            ->get();

        $cancelled_joined_events = Event::whereHas('eventParticipants', function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('cancelled_at', null);
        })
            ->where('completed_at', null)
            ->where('cancelled_at', '!=', null)
            ->withCount(['eventParticipants' => function ($query) {
                $query->where('cancelled_at', null)->with('user');
            }])
            ->with(['eventLikes', 'eventTags.tag'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('user.mypage.events-joined', compact('before_held_joined_events', 'after_held_joined_events', 'cancelled_joined_events'));
    }

    public function eventsLiked()
    {
        $user = Auth::user();

        $before_held_liked_events = Event::whereHas('eventLikes', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->where('completed_at', null)
            ->where('cancelled_at', null)
            ->withCount(['eventParticipants' => function ($query) {
                $query->where('cancelled_at', null);
            }])
            ->with(['eventParticipants' => function ($query) {
                $query->where('cancelled_at', null)->with('user');
            }])
            ->where('user_id', '!=', $user->id)
            ->with('eventLikes', 'eventTags.tag')
            ->orderBy('created_at', 'desc')
            ->get();

        $after_held_liked_events = Event::whereHas('eventLikes', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->where('completed_at', '!=', null)
            ->where('cancelled_at', null)
            ->withCount(['eventParticipants' => function ($query) {
                $query->where('cancelled_at', null);
            }])
            ->with(['eventParticipants' => function ($query) {
                $query->where('cancelled_at', null)->with('user');
            }])
            ->where('user_id', '!=', $user->id)
            ->with('eventLikes', 'eventTags.tag')
            ->orderBy('created_at', 'desc')
            ->get();

        $cancelled_liked_events = Event::whereHas('eventLikes', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->where('completed_at', null)
            ->where('cancelled_at', '!=', null)
            ->withCount(['eventParticipants' => function ($query) {
                $query->where('cancelled_at', null);
            }])
            ->with(['eventParticipants' => function ($query) {
                $query->where('cancelled_at', null)->with('user');
            }])
            ->where('user_id', '!=', $user->id)
            ->with('eventLikes', 'eventTags.tag')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.mypage.events-liked', compact('user', 'before_held_liked_events', 'after_held_liked_events', 'cancelled_liked_events'));
    }

    public function requestsPosted()
    {
        $user = Auth::user();

        $resolved_requests = Request::where('user_id', $user->id)
            ->resolvedRequests()
            ->with('requestLikes')
            ->with('requestTags.tag')
            ->withCount('requestLikes')
            ->orderBy('created_at', 'desc')
            ->get();

        $unresolved_requests = Request::where('user_id', $user->id)
            ->unresolvedRequests()
            ->with('requestLikes')
            ->with('requestTags.tag')
            ->withCount('requestLikes')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.mypage.requests-posted', compact('resolved_requests', 'unresolved_requests'));
    }

    public function requestsLiked()
    {
        $user = Auth::user();

        $unresolved_liked_requests = Request::whereHas('requestLikes', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->where('completed_at', null)
            ->where('user_id', '!=', $user->id)
            ->with(['requestTags.tag', 'requestLikes'])
            ->withCount('requestLikes')
            ->orderBy('created_at', 'desc')
            ->get();

        $resolved_liked_requests = Request::whereHas('requestLikes', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->where('completed_at', '!=', null)
            ->where('user_id', '!=', $user->id)
            ->with(['requestTags.tag', 'requestLikes'])
            ->withCount('requestLikes')
            ->orderBy('created_at', 'desc')
            ->get();
        $product_request_type_id = Request::PRODUCT_REQUEST_TYPE_ID;

        return view('user.mypage.requests-liked', compact('user', 'product_request_type_id', 'unresolved_liked_requests', 'resolved_liked_requests'));
    }

    public function userProfile($user_id)
    {
        // ユーザーの情報と部署の情報を紐づけて取得
        $user = User::where('id', $user_id)->with('department')->first();
        // アイテム
        $japanese_product_statuses = Product::JAPANESE_STATUS;
        unset($japanese_product_statuses[1]);
        $products = Product::where('user_id', $user_id)->approvedProducts()->withRelations()->get()->map(function ($product) use ($japanese_product_statuses) {
            $product->data_tag = '[' . implode(',', $product->productTags->pluck('tag_id')->toArray()) . ']';
            //配送中は貸出中として表示
            if ($product->status === Product::STATUS['delivering']) {
                $product->japanese_status = $japanese_product_statuses[Product::STATUS['occupied']];
                $product->status = Product::STATUS['occupied'];
            } else {
                $product->japanese_status = $japanese_product_statuses[$product->status];
            }
            if ($product->productLikes->contains('user_id', Auth::id())) {
                $product->isLiked = 1;
            } else {
                $product->isLiked = 0;
            }
            $product->description = $product->changeDescriptionReturnToBreakTag($product->description);
            return $product;
        })->sortByDesc('created_at');

        // イベント
        $events = Event::where('user_id', $user_id)->withCount('eventLikes')->withCount(['eventParticipants' => function ($query) {
            $query->where('cancelled_at', null);
        }])->with(['user', 'eventTags.tag', 'eventLikes.user'])->with(['eventParticipants' => function ($query) {
            $query->where('cancelled_at', null)->with('user');
        }])->get()->map(function ($event) use ($user_id) {
            $event->isLiked = $event->eventLikes->contains('user_id', $user_id);
            $event->isParticipated = $event->eventParticipants->contains('user_id', $user_id);
            if (empty($event->completed_at)) {
                $event->isCompleted = Event::COMPLETED_STATUSES[0];
            } else {
                $event->isCompleted = Event::COMPLETED_STATUSES[1];
            }
            $event->data_tag = '[' . implode(',', $event->eventTags->pluck('tag_id')->toArray()) . ']';
            $event->description = $event->changeDescriptionReturnToBreakTag($event->description);
            if ($event->eventLikes->contains('user_id', Auth::id())) {
                $event->isLiked = 1;
            } else {
                $event->isLiked = 0;
            }
            return $event;
        })->sortByDesc('created_at');

        // リクエスト
        $event_request_type_id = ModelsRequest::EVENT_REQUEST_TYPE_ID;
        $product_request_type_id = ModelsRequest::PRODUCT_REQUEST_TYPE_ID;
        $app = [
            $product_request_type_id => ['color' => 'text-blue-400', 'name' => 'Peer Product Share', 'japanese_name' => 'アイテム'],
            $event_request_type_id => ['color' => 'text-pink-600', 'name' => 'Peer Event', 'japanese_name' => 'イベント']
        ];
        $requests = ModelsRequest::where('user_id', $user_id)->with(['user', 'requestTags.tag'])->withCount('requestLikes')->orderBy('created_at', 'desc')->unresolvedRequests()->get()->map(function ($request) {
            $request->description = $request->changeDescriptionReturnToBreakTag($request->description);
            $request->data_tag = '[' . implode(',', $request->requestTags->pluck('tag_id')->toArray()) . ']';
            if ($request->requestLikes->contains('user_id', Auth::id())) {
                $request->isLiked = 1;
            } else {
                $request->isLiked = 0;
            }
            return $request;
        });

        return view('user.profile', compact('user', 'products', 'japanese_product_statuses', 'events', 'requests', 'app', 'event_request_type_id', 'product_request_type_id'));
    }
}
