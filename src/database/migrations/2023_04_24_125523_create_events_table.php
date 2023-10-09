<?php

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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('title');
            $table->text('description');
            $table->timestamp('start_date')->default(null)->nullable();
            $table->timestamp('end_date')->default(null)->nullable();
            $table->string('location');
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('request_id')->nullable()->constrained('requests');
            $table->timestamps();
            $table->softDeletes();
        });


        $events_array = [
            [
                'user_id' => 2,
                'title' => 'PHPを語り合う会',
                'description' => "動的型付け言語であるPHPは、手軽にコードを記述できる反面、 保守性の担保、または意図しない挙動を防ぐため、常に型を意識してコーディングを行う必要があります。\nしかし、手軽に書ける反面、PHPを始めたばかりの人の中には、あまり型を意識せず記載している人もいるのではないでしょうか？\n今回のPHPTechCafeでは、そんな方のために型のとの付き合い方を語り合います！！",
                'start_date' => null,
                'end_date' => null,
                'location' => 'オンライン',
                'completed_at' => null,
                'created_at' => '2023/05/03 20:26:02',
                'request_id' => 2,
                'deleted_at' => null
            ],
            //日をまたぐ
            [
                'user_id' => 3,
                'title' => 'Tailwind講座',
                'description' => "Tailwindをマスターしたい人向けの講座となっております。",
                'start_date' => '2023/05/10 22:00:00',
                'end_date' => '2023/05/11 01:00:00',
                'location' => '対面',
                'completed_at' => '2023/05/11 01:00:00',
                'created_at' => '2023/05/06 20:26:02',
                'request_id' => 3,
                'deleted_at' => null
            ],
            [
                'user_id' => 1,
                'title' => 'Goodcode,Badcode',
                'description' => '良いコード、悪いコードの違いってなに？を徹底的に解き明かしていきましょう！',
                'start_date' => null,
                'end_date' => null,
                'location' => 'オンライン',
                'completed_at' => null,
                'created_at' => '2023/05/09 20:26:02',
                'request_id' => null,
                'deleted_at' => null
            ],
            //発表過ぎてない
            [
                'user_id' => 4,
                'title' => 'React勉強会',
                'description' => 'Reactの基本的な操作を学ぶ会です。',
                'start_date' => '2023/05/15 20:00:00',
                'end_date' => '2023/05/15 22:00:00',
                'location' => 'オンライン',
                'completed_at' => '2023/05/15 22:00:00',
                'created_at' => '2023/05/12 20:26:02',
                'request_id' => null,
                'deleted_at' => null
            ],
            [
                'user_id' => 3,
                'title' => 'Ruby・Rails勉強会',
                'description' => "Ruby・Railsの困っている事を相談したり、\nもくもく会や読書会など色々な活動を行いたいと思っています。\n何をするかは決めていないので、色々ご提案していただけると幸いです。",
                'start_date' => null,
                'end_date' => null,
                'location' => '対面',
                'completed_at' => null,
                'created_at' => '2023/05/15 20:26:02',
                'request_id' => 6,
                'deleted_at' => null
            ],
            [
                'user_id' => 4,
                'title' => 'Rustオンラインもくもく会',
                'description' => "OS自作をやっている人々で集まって、進捗を共有したり、\nみんなで黙々と作業をする時間をとる会です。\nこのイベントの対象は次のような方々です。\n自作OSに興味があり、OS関係の本を読んでいる(または今から読み始める)\n自分のOSを作っている、既存のOSを学んでいる・改造している\n低レイヤ技術に興味があり、情報交換したい",
                'start_date' => null,
                'end_date' => null,
                'location' => 'オンライン',
                'completed_at' => null,
                'created_at' => '2023/05/18 20:26:02',
                'request_id' => 5,
                'deleted_at' => null
            ],
            [
                'user_id' => 4,
                'title' => 'AI勉強会',
                'description' => "AI開発における「データ」に着目した取り組みについて、\n世界的な動向や、様々な人・組織の知見・ノウハウなどを共有するための勉強会です。\n具体的なテーマとしては、例えばデータ収集の工夫、データ品質の評価・改善、アノテーションの効率化など様々なものが考えられます。\nデータに主眼を置いたものを幅広く対象とします。",
                'start_date' => '2023/06/10 20:00:00',
                'end_date' => '2023/06/10 21:00:00',
                'location' => '対面',
                'completed_at' => null,
                'created_at' => '2023/05/21 20:26:02',
                'request_id' => null,
                'deleted_at' => null
            ],
            [
                'user_id' => 1,
                'title' => '朝からもくもく会',
                'description' => "朝は脳のゴールデンタイムです。\n『朝・毎日・決まった時間・やることを宣言』これで驚くほど学習が捗ります。\n朝学習を習慣化して、一緒にもくもく朝活しましょう！！",
                'start_date' => null,
                'end_date' => null,
                'location' => '対面',
                'completed_at' => null,
                'created_at' => '2023/05/24 20:26:02',
                'request_id' => null,
                'deleted_at' => null
            ],
            [
                'user_id' => 1,
                'title' => 'セキュリティから学ぶ機械学習',
                'description' => "「Pythonに触れてみたい...！」「深層学習をやってみたい...！」という方々をはじめ、\n現場でプログラミングに悩むヒトにもデータ分析を通して「使える」プログラミングを学べます...！\n複数回開催される勉強会に継続的に参加していくことで、機械学習分野における基本を体系的に理解し、\nそして自身でもビジネスへのデータサイエンス活用が可能になることを目指しております。",
                'start_date' => '2023/06/06 15:00:00',
                'end_date' => '2023/06/06 17:00:00',
                'location' => '対面',
                'completed_at' => null,
                'created_at' => '2023/05/27 20:26:02',
                'request_id' => null,
                'deleted_at' => null
            ],
            //発表過ぎてる
            [
                'user_id' => 3,
                'title' => 'Redmineパッチ会',
                'description' => "Redmineの改善に興味ある方であればどなたでも。\n参加者はみんながみんな必ずしもRuby・Railsに精通しているわけではなく、\nそれぞれのできる範囲で少しずつ成長を重ねながらRedmineの改善に取り組んでいます。\nたとえば、プログラミングせずに画面の文言変更でもパッチは送れます。",
                'start_date' => '2023/06/10 10:00:00',
                'end_date' => '2023/06/10 12:00:00',
                'location' => 'オンライン',
                'completed_at' => null,
                'created_at' => '2023/05/30 20:26:02',
                'request_id' => null,
                'deleted_at' => null
            ],
        ];

        DB::table('events')->insert($events_array);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
