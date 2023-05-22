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
        $unchargeable_month_count = ProductDealLog::UNCHARGEABLE_MONTH_COUNT;
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
                if ($last_of_product_deal_log_grouped_by_product_id->month_count + 1 != $unchargeable_month_count) {
                    //差引不可能なmonth_count以外の場合は引く
                    $user->changeDistributionPoint(-$product->point);
                    // 貸した人はポイント増える
                    $product->user->changeEarnedPoint($product->point);
                }
                //product_deal_log新しく作る
                //month_countにunchargeable_month_countをいれるときpointカラムには0いれる
                if ($last_of_product_deal_log_grouped_by_product_id->month_count + 1 === $unchargeable_month_count) {
                    $product->addProductDealLog($product->id, $user->id, 0, $last_of_product_deal_log_grouped_by_product_id->month_count + 1);
                } else {
                    $product->addProductDealLog($product->id, $user->id, $product->point, $last_of_product_deal_log_grouped_by_product_id->month_count + 1);
                }
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