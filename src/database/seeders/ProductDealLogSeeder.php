<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Product;
use App\Models\ProductDealLog;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductDealLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $product_instance = new Product();
        $product_ids = $product_instance->availableProducts()->getProductIds();
        $user_ids = User::getUserIds();
        //返却済み
        //ポイントの変動とステータスの変動考えるのめんどくさいから先月返したことにする
        foreach ($product_ids as $product_id) {
            $product_deals_array[] = [
                'product_id' => $product_id,
                'user_id' => $faker->randomElement($user_ids),
                'created_at' => Carbon::now()->subMonths(2),
                'returned_at' => Carbon::now()->subMonth()
            ];
        }
        //利用中
        foreach ($product_ids as $product_id) {
            $product_deals_array[] = [
                'product_id' => $product_id,
                'user_id' => $faker->randomElement($user_ids),
                'created_at' => Carbon::now(),
                'returned_at' => null
            ];
        }
        DB::table('product_deal_logs')->insert($product_deals_array);
        //usersテーブルのpointカラムを更新
        $product_deal_log_instance = new ProductDealLog();
        //すべてのアイテムを貸した人のearned_pointを増やす=>created_atとreturned_atの差分を求める例：1,2=>2ヵ月count(range(1,2))=2,returned_atがnullの場合はnow()を使う
        $product_instance->availableProducts()->with('productDealLogs')->each(function ($product) {
            $month_sum_per_product = 0;
            $product->productDealLogs->each(function ($product_deal_log) use (&$month_sum_per_product) {
                $timestamp_before = Carbon::parse($product_deal_log->created_at);
                if (empty($product_deal_log->returned_at)) {
                    $timestamp_after = Carbon::now();
                    $month_diff = ceil($timestamp_before->diffInMonths($timestamp_after, false));
                } else {
                    $timestamp_after = Carbon::parse($product_deal_log->returned_at);
                    $month_diff = ceil($timestamp_before->diffInMonths($timestamp_after, false));
                }
                $month_sum_per_product += $month_diff;
            });
            $user_instance = User::findOrFail($product->user_id);
            $user_instance->update(['earned_point' => $user_instance->earned_point + $month_sum_per_product * $product->point]);
        });

        //今月のアイテムを借りた人のdistribution_pointを減らす
        $items_borrowed_this_month = $product_deal_log_instance->with('product')->borrowedThisMonth()->with('product')->get()->groupBy('user_id');
        $items_borrowed_this_month->each(function ($product_deal_log, $user_id) {
            $user_instance = User::findOrFail($user_id);
            $point_sum = $product_deal_log->sum(function ($product_deal_log) {
                return $product_deal_log->product->point;
            });
            $user_instance->update(['distribution_point' => $user_instance->distribution_point - $point_sum]);
        });
    }
}
