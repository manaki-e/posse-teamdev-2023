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
        $products = $product_instance->approvedProducts()->getProductIdsAndPoints();
        $user_ids = User::getUserIds();
        //返却済み
        //ポイントの変動とステータスの変動考えるのめんどくさいから先月返したことにする
        $loop_count = 1;
        $last_product_deal_log_id = ProductDealLog::latest('id')->value('id');
        foreach ($products as $product) {
            $product_deals_array[] = [
                'product_id' => $product->id,
                'point' => $product->point,
                'start_of_streak_id' => $last_product_deal_log_id + $loop_count,
                'user_id' => $faker->randomElement($user_ids),
                'created_at' => Carbon::now()->subMonths(2),
                'returned_at' => Carbon::now()->subMonth(2)
            ];
            $loop_count++;
        }
        //利用中
        foreach ($products as $product) {
            $product_deals_array[] = [
                'product_id' => $product->id,
                'point' => $product->point,
                'start_of_streak_id' => $last_product_deal_log_id + $loop_count,
                'user_id' => $faker->randomElement($user_ids),
                'created_at' => Carbon::now(),
                'returned_at' => null
            ];
            $loop_count++;
        }
        DB::table('product_deal_logs')->insert($product_deals_array);
        //usersテーブルのpointカラムを更新
        $product_deal_log_instance = new ProductDealLog();
        //すべてのアイテムを貸した人のearned_pointを増やす=>created_atとreturned_atの差分を求める例：1,2=>2ヵ月count(range(1,2))=2,returned_atがnullの場合はnow()を使う
        $product_instance->approvedProducts()->with('productDealLogs')->each(function ($product) {
            //合計ポイントの変動
            $total_point_change = $product->productDealLogs->sum(function ($product_deal_log) {
                return $product_deal_log->point;
            });
            $user_instance = User::findOrFail($product->user_id);
            $user_instance->update(['earned_point' => $user_instance->earned_point + $total_point_change]);
        });

        //今月のアイテムを借りた人のdistribution_pointを減らす
        $items_borrowed_this_month = $product_deal_log_instance->with('product')->borrowedThisMonth()->with('product')->get()->groupBy('user_id');
        $items_borrowed_this_month->each(function ($product_deal_log, $user_id) {
            $user_instance = User::findOrFail($user_id);
            $point_sum = $product_deal_log->sum(function ($product_deal_log) {
                return $product_deal_log->point;
            });
            $user_instance->update(['distribution_point' => $user_instance->distribution_point - $point_sum]);
        });
    }
}