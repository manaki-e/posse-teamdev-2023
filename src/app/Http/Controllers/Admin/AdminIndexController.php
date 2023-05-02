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
        $event_participants = $this->event_participants();
        $product_deals = $this->product_deals();
    }
    public function product_deals()
    {
        //figmaには一画面8項目だったので、paginate(8)を追加
        //貸した人、商品名、借りた人、ポイント、借りた日時、返却日時
        $deal_logs_with_products = ProductDealLog::with('product.user')->with('user')->paginate(8);
        foreach ($deal_logs_with_products as $deal_log_with_product) {
            print_r($deal_log_with_product->product->user->name . "\n");
            print_r($deal_log_with_product->product->title . "\n");
            print_r($deal_log_with_product->user->name . "\n");
            print_r($deal_log_with_product->product->point . "\n");
            print_r($deal_log_with_product->created_at->format('Y年m月d日 H:i:s') . "\n");
            print_r($deal_log_with_product->returned_at->format('Y年m月d日 H:i:s') . "\n");
            dd();
        }
        return $deal_log_with_products;
    }
    public function event_participants()
    {
        //figmaには一画面8項目だったので、paginate(8)を追加
        //イベント名、参加者名、登録日時
        $event_participants = EventParticipantLog::with('event')->with('user')->paginate(8);
        foreach ($event_participants as $event_participant) {
            print_r($event_participant->event->title . "\n");
            print_r($event_participant->user->name . "\n");
            print_r($event_participant->created_at->format('Y年m月d日 H:i:s') . "\n");
            dd();
        }
        return $event_participants;
    }
    public function point_exchanges(){
        $done_point_exchanges=PointExchangeLog::with('user')->approved()->get();
        foreach($done_point_exchanges as $done_point_exchange){
            print_r($done_point_exchange->user->name."\n");
            print_r($done_point_exchange->point."\n");
            print_r($done_point_exchange->created_at->format('Y年m月d日 H:i:s')."\n");
            print_r($done_point_exchange->updated_at->format('Y年m月d日 H:i:s')."<br>");
        }
        $undone_point_exchanges=PointExchangeLog::with('user')->pending()->get();
        foreach($undone_point_exchanges as $undone_point_exchange){
            print_r($undone_point_exchange->user->name."\n");
            print_r($undone_point_exchange->point."\n");
            print_r($undone_point_exchange->created_at->format('Y年m月d日 H:i:s')."<br>");
        }
        dd();
        return view('admin.point-exchanges',compact('done_point_exchanges','undone_point_exchanges'));
    }
}