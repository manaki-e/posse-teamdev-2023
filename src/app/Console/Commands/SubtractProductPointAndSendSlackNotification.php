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
        ProductDealLog::with(['user', 'product'])->get()->groupBy('start_of_streak_id')->map(function ($product_deal_log_grouped_by_start_of_streak_id) {
            //連続ごとにグループしてその最後のレコードを取得
            $first_of_product_deal_log_grouped_by_start_of_streak_id = $product_deal_log_grouped_by_start_of_streak_id->first();
            $last_of_product_deal_log_grouped_by_start_of_streak_id = $product_deal_log_grouped_by_start_of_streak_id->last();
            //キャンセルまたは返却済みの場合は何もしない
            if (!empty($last_of_product_deal_log_grouped_by_start_of_streak_id->returned_at) || !empty($last_of_product_deal_log_grouped_by_start_of_streak_id->canceled_at)) {
                return;
            } else {
                //user_idとproduct_idを元にuserとproductを取得
                $user = User::find($last_of_product_deal_log_grouped_by_start_of_streak_id->user_id);
                $product = Product::find($last_of_product_deal_log_grouped_by_start_of_streak_id->product_id);
                $start_date = Carbon::create($first_of_product_deal_log_grouped_by_start_of_streak_id->created_at);
                $end_date = Carbon::now();
                $more_than_two_months_has_passed_since_start_of_streak = $start_date->diffInMonths($end_date) + 1 > 2;
                //連続の最初に借りたときから三か月以上経っていたらポイント引き出す=>ポイント移行履歴にも反映しなきゃ
                if ($more_than_two_months_has_passed_since_start_of_streak) {
                    //userのdistribution_pointから引く
                    $user->distribution_point -= $product->point;
                    $user->save();
                }
                //product_deal_log新しく作る
                $product_deal_log = new ProductDealLog();
                $product_deal_log->user_id = $user->id;
                $product_deal_log->product_id = $product->id;
                $product_deal_log->point = $product->point;
                $product_deal_log->start_of_streak_id = $last_of_product_deal_log_grouped_by_start_of_streak_id->start_of_streak_id;
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