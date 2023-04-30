<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductDealLog;
use Illuminate\Http\Request;

class AdminIndexController extends Controller
{
    public function deals()
    {
        //figmaには一画面8項目だったので、paginate(8)を追加
        //商品名、借りた人、ポイント、借りた日時、返却日時
        $deal_logs_with_products = ProductDealLog::with('product')->with('user')->paginate(8);
        foreach ($deal_logs_with_products as $deal_log_with_product) {
            print_r($deal_log_with_product->product->title . "\n");
            print_r($deal_log_with_product->user->name . "\n");
            print_r($deal_log_with_product->product->point . "\n");
            print_r($deal_log_with_product->created_at->format('Y/m/d H:i:s') . "\n");
            print_r($deal_log_with_product->returned_at->format('Y/m/d H:i:s') . "\n");
            dd();
        }
        // return view('admin.deals',compact('deal_logs_with_products'));
    }
}