<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipantLog;
use App\Models\PointExchangeLog;
use App\Models\ProductDealLog;

class AdminIndexController extends Controller
{
    public function histories()
    {
        //peerpoint変動item
        $peer_point_product_transfer_logs=ProductDealLog::with(['product'=>function($query){
            $query->withTrashed()->with(['user'=>function($query){
                $query->withTrashed();
            }]);
        }])->with(['user'=>function($query){
            $query->withTrashed();
        }])->get();
        // foreach($peer_point_product_transfer_logs as $peer_point_product_transfer_log){
        //     print_r($peer_point_product_transfer_log->product->title);
        //     print_r($peer_point_product_transfer_log->point);
        //     print_r($peer_point_product_transfer_log->user->name);
        //     print_r($peer_point_product_transfer_log->product->user->name);
        //     print_r($peer_point_product_transfer_log->created_at->format('Y.m.d'));
        //     print_r(empty($peer_point_product_transfer_log->returned_at)?'未返却':$peer_point_product_transfer_log->returned_at->format('Y.m.d'));
        //     print_r('<br>');
        // }
        //peerpoint変動event
        $peer_point_event_transfer_logs=EventParticipantLog::with(['event'=>function($query){
            $query->withTrashed()->with(['user'=>function($query){
                $query->withTrashed();
            }]);
        }])->with(['user'=>function($query){
            $query->withTrashed();
        }])->get();
        // foreach($peer_point_event_transfer_logs as $peer_point_event_transfer_log){
        //     print_r($peer_point_event_transfer_log->event->title);
        //     if(!empty($peer_point_event_transfer_log->event->cancelled_at)){
        //         print_r('開催中止');
        //     }elseif(!empty($peer_point_event_transfer_log->event->completed_at)){
        //         print_r('開催済み');
        //     }else{
        //         print_r('開催予定');
        //     }
        //     print_r($peer_point_event_transfer_log->point);
        //     print_r($peer_point_event_transfer_log->user->name);
        //     print_r($peer_point_event_transfer_log->event->user->name);
        //     print_r($peer_point_event_transfer_log->created_at->format('Y.m.d'));
        //     print_r('<br>');
        // }
        //bonuspoint変動item
        $bonus_point_product_transfer_logs=ProductDealLog::with(['product'=>function($query){
            $query->withTrashed()->with(['user'=>function($query){
                $query->withTrashed();
            }]);
        }])->with(['user'=>function($query){
            $query->withTrashed();
        }])->get();
        // foreach($bonus_point_product_transfer_logs as $bonus_point_product_transfer_log){
        //     print_r($bonus_point_product_transfer_log->product->title);
        //     print_r($bonus_point_product_transfer_log->point);
        //     print_r($bonus_point_product_transfer_log->user->name);
        //     print_r($bonus_point_product_transfer_log->product->user->name);
        //     print_r($bonus_point_product_transfer_log->created_at->format('Y.m.d'));
        //     print_r(empty($bonus_point_product_transfer_log->returned_at)?'未返却':$bonus_point_product_transfer_log->returned_at->format('Y.m.d'));
        //     print_r('<br>');
        // }
        //bonuspoint変動event
        $bonus_point_event_transfer_logs=Event::withSum('eventParticipants','point')->with(['user'=>function($query){
            $query->withTrashed();
        }])->withCount('eventParticipants')->get();
        // foreach($bonus_point_event_transfer_logs as $bonus_point_event_transfer_log){
        //     print_r($bonus_point_event_transfer_log->title);
        //     print_r(empty($bonus_point_event_transfer_log->event_participants_sum_point)?0:$bonus_point_event_transfer_log->event_participants_sum_point);
        //     print_r($bonus_point_event_transfer_log->user->name);
        //     print_r($bonus_point_event_transfer_log->event_participants_count."人");
        //     if(!empty($bonus_point_event_transfer_log->cancelled_at)){
        //         print_r('開催中止');
        //     }elseif(!empty($bonus_point_event_transfer_log->completed_at)){
        //         print_r('開催済み');
        //     }else{
        //         print_r('開催予定');
        //     }
        //     print_r('<br>');
        // }
        dd();
        // return view('admin.histories', compact('product_deals', 'event_participants'));
    }

    public function pointExchanges()
    {
        // ユーザを削除した時にエラーが出るので注意
        $done_point_exchanges = PointExchangeLog::with('user')->approved()->paginate(10, ['*'], 'done_page')->appends(['undone_page' => request('undone_page')]);
        $undone_point_exchanges = PointExchangeLog::with('user')->pending()->paginate(10, ['*'], 'undone_page')->appends(['done_page' => request('done_page')]);

        return view('admin.point-exchanges', compact('done_point_exchanges', 'undone_point_exchanges'));
    }
}
