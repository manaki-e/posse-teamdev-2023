<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductDealLog;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SubtractProductPointAndSendSlackNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:subtract_product_point_and_send_slack_notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '定期ポイント引き出しとslack通知';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ProductDealLog::with(['user', 'product'])->get()->groupBy('product_id')->map(function ($product_deal_log_grouped_by_product_id) use ($unchargeable_month_count) {
            //productごとにグループしてその最後のレコードを取得
            $last_of_product_deal_log_grouped_by_product_id = $product_deal_log_grouped_by_product_id->last();
            //キャンセルまたは返却済みの場合は何もしない
            if (!empty($last_of_product_deal_log_grouped_by_product_id->returned_at) || !empty($last_of_product_deal_log_grouped_by_product_id->canceled_at)) {
                return;
            } else {
                //user_idとproduct_idを元にuserとproductを取得
                $user = User::find($last_of_product_deal_log_grouped_by_product_id->user_id);
                $product = Product::find($last_of_product_deal_log_grouped_by_product_id->product_id);
                //差引不可能なmonth_count以外の場合は引く
                if ($last_of_product_deal_log_grouped_by_product_id->month_count + 1 != $unchargeable_month_count) {
                    $user->distribution_point -= $product->point;
                    $user->save();
                }
                //product_deal_log新しく作る
                $product_deal_log = new ProductDealLog();
                $product_deal_log->user_id = $user->id;
                $product_deal_log->product_id = $product->id;
                //1をいれるときpointカラムには0いれる＝＞まなきの承認あり
                $month_count = $last_of_product_deal_log_grouped_by_product_id->month_count + 1;
                if ($month_count === $unchargeable_month_count) {
                    $product_deal_log->point = 0;
                } else {
                    $product_deal_log->point = $product->point;
                }
                $product_deal_log->month_count = $month_count;
                $product_deal_log->save();
                //！！！ここにまなきがslack通知の処理を書く！！！
                return;
            }
        });
        //laravel.logに記録
        Log::info('定期ポイント引き出し完了');
        // Log::info('slack通知完了');
        return Command::SUCCESS;
    }
}
