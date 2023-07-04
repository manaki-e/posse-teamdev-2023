<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventParticipantLog;
use App\Models\PointExchangeLog;
use App\Models\ProductDealLog;

class AdminIndexController extends Controller
{
    public function histories()
    {
        // アイテムやユーザを削除した時にエラーが出るので注意
        $product_deals = ProductDealLog::with(['product'=>function($query){
            $query->withTrashed()->with(['user'=>function($query){
                $query->withTrashed();
            }]);
        }])->with(['user'=>function($query){
            $query->withTrashed();
        }])->withTrashed()->paginate(10, ['*'], 'product_deal')->appends(['event_participant' => request('event_participant')]);
        $event_participants = EventParticipantLog::with('event')->with('user')->paginate(10, ['*'], 'event_participant')->appends(['product_deal' => request('product_deal')]);

        return view('admin.histories', compact('product_deals', 'event_participants'));
    }

    public function pointExchanges()
    {
        // ユーザを削除した時にエラーが出るので注意
        $done_point_exchanges = PointExchangeLog::with('user')->approved()->paginate(10, ['*'], 'done_page')->appends(['undone_page' => request('undone_page')]);
        $undone_point_exchanges = PointExchangeLog::with('user')->pending()->paginate(10, ['*'], 'undone_page')->appends(['done_page' => request('done_page')]);

        return view('admin.point-exchanges', compact('done_point_exchanges', 'undone_point_exchanges'));
    }
}
