<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('point')->default(null)->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->integer('status')->default(Product::STATUS['pending']);
            $table->integer('condition');
            $table->string('description');
            $table->foreignId('request_id')->nullable()->constrained('requests');
            $table->timestamps();
            $table->softDeletes();
        });

        $products_array = [
            [
                'title' => 'Macbook',
                'point' => null,
                'description' => "写真編集とSNS投稿\nプログラミングを学んでホームページ制作やアプリ開発\nデザインソフトを使って自分の商品やブランド作り\n動画編集\n色々なことができる高性能パソコンです。",
                'status' => 1,
                'condition' => 6,
                'request_id' => 4,
                'user_id' => 5,
                'created_at' => '2023/05/25 20:26:02',
                'deleted_at' => null
            ],
            [
                'title' => 'ロジクール(Logicool) MX MASTER 3S MX2300',
                'point' => null,
                'description' => "静かなクリック音を実現 – 静音でありながら以前と同じクリック感を維持しつつ、\nクリックノイズが90%減少された静かなクリックが、満足のいくソフトなタクタイル、\nフィードバックを実現します。",
                'status' => 1,
                'condition' => 6,
                'request_id' => null,
                'user_id' => 3,
                'created_at' => '2023/05/26 20:26:02',
                'deleted_at' => null
            ],
            [
                'title' => 'Logicool キーボード MX Mechanical 茶軸 KX850FT',
                'point' => 1500,
                'description' => "二年ほど使用していないキーボードです。",
                'status' => 2,
                'condition' => 2,
                'request_id' => 8,
                'user_id' => 4,
                'created_at' => '2023/05/27 20:26:02',
                'deleted_at' => '2023/05/27 20:30:00'
            ],
            [
                'title' => 'Airpods Pro',
                'point' => 4500,
                'description' => "超高性能ヘッドフォンを購入したため、使用しなくなりました。",
                'status' => 2,
                'condition' => 4,
                'request_id' => null,
                'user_id' => 1,
                'created_at' => '2023/05/28 20:26:02',
                'deleted_at' => null
            ],
            [
                'title' => 'アンカー(ANKER) Anker 727 Charging Station A9126NF1',
                'point' => 3000,
                'description' => "最大出力100Wかつ、6ポート搭載で6台の機器を同時に充電が可能。\nMacBook Air、iPhone 14、AirPodsもこれ一つで充電ができます。",
                'status' => 2,
                'condition' => 2,
                'request_id' => null,
                'user_id' => 2,
                'created_at' => '2023/05/29 20:26:02',
                'deleted_at' => null
            ],
            [
                'title' => 'FlexiSpot E7',
                'point' => 2500,
                'description' => "簡単にスタンディングデスクに切り替えられます。",
                'status' => 1,
                'condition' => 3,
                'request_id' => null,
                'user_id' => 1,
                'created_at' => '2023/05/30 20:26:02',
                'deleted_at' => null
            ],
            [
                'title' => 'アンカー(ANKER) Anker 511 Power Bank A1633N13',
                'point' => 1000,
                'description' => "Anker PowerCore Fusionシリーズ初のリップスティック型が登場。\nポーチやミニバッグにもすっぽりと収まる小型デザインを実現しました。\nストラップ付きで取り出しやすく、\n折りたたみ式プラグを採用しているため持ち運びにも最適です。",
                'status' => 2,
                'condition' => 6,
                'request_id' => null,
                'user_id' => 2,
                'created_at' => '2023/05/31 20:26:02',
                'deleted_at' => null
            ],
            [
                'title' => 'Satechi デュアルバーティカルスタンド',
                'point' => 3000,
                'description' => "家の中ではスタンドを利用してマグネット式ワイヤレス充電器として、\n外出先ではスタンドを折りたたみマグネット式ワイヤレス充電対応のモバイルバッテリーとして2通りでの利用が可能。\nご自宅でも外出先でもマグネット式ワイヤレス充電を利用可能。",
                'status' => 1,
                'condition' => 3,
                'request_id' => 1,
                'user_id' => 3,
                'created_at' => '2023/06/01 20:26:02',
                'deleted_at' => null
            ],
            [
                'title' => 'Shokz OpenRun Pro',
                'point' => 2500,
                'description' => "第九世代の骨伝導テクノロジー（Shokz TurboPitchテクノロジー）を採用し、\n鮮明でクリアな中高音を実現するとともに、\n新しいShokz TurboPitchテクノロジーにより、\n驚くほど深みのある低音を実現しています。",
                'status' => 1,
                'condition' => 3,
                'request_id' => null,
                'user_id' => 1,
                'created_at' => '2023/06/02 20:26:02',
                'deleted_at' => null
            ],
            [
                'title' => 'サムスン(Samsung) Galaxy Watch5 SM-R900NZAAXJP',
                'point' => 1000,
                'description' => "自分自身のスタイルで、\n自分の健康を管理するための最も便利なツール。\n正確なヘルスモニタリング。",
                'status' => 1,
                'condition' => 1,
                'request_id' => null,
                'user_id' => 5,
                'created_at' => '2023/06/03 20:26:02',
                'deleted_at' => null
            ],
        ];
        DB::table('products')->insert($products_array);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
