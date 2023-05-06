<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventParticipantLog;
use App\Models\PointExchangeLog;
use App\Models\ProductDealLog;
use Illuminate\Http\Request;

class AdminIndexController extends Controller
{
    public function histories()
    {
        $product_deals = ProductDealLog::with('product.user')->with('user')->paginate(10, ['*'], 'product_deal')->appends(['event_participant' => request('event_participant')]);
        $event_participants = EventParticipantLog::with('event')->with('user')->paginate(10, ['*'], 'event_participant')->appends(['product_deal' => request('product_deal')]);

        return view('admin.histories', compact('product_deals', 'event_participants'));
    }

    public function pointExchanges()
    {
        $done_point_exchanges = PointExchangeLog::with('user')->approved()->paginate(8, ['*'], 'done_page')->appends(['undone_page' => request('undone_page')]);
        print_r($_SERVER['REQUEST_URI'] . '<br>');
        print_r('換金対応済み<br>');
        foreach ($done_point_exchanges as $done_point_exchange) {
            print_r($done_point_exchange->user->name . "\n");
            print_r($done_point_exchange->point . "\n");
            print_r($done_point_exchange->created_at->format('Y年m月d日 H:i:s') . "\n");
            print_r($done_point_exchange->updated_at->format('Y年m月d日 H:i:s') . "<br>");
        }
        print_r('換金未対応<br>');
        $undone_point_exchanges = PointExchangeLog::with('user')->pending()->paginate(8, ['*'], 'undone_page')->appends(['done_page' => request('done_page')]);
        foreach ($undone_point_exchanges as $undone_point_exchange) {
            print_r($undone_point_exchange->user->name . "\n");
            print_r($undone_point_exchange->point . "\n");
            print_r($undone_point_exchange->created_at->format('Y年m月d日 H:i:s') . "<br>");
        }
        dd();
        return view('admin.point-exchanges', compact('done_point_exchanges', 'undone_point_exchanges'));
    }
}
