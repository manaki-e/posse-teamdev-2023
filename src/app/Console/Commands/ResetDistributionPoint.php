<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ResetDistributionPoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:reset_distribution_point';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '定期ポイント配布';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //配布ポイントの設定値を取得
        $distribution_point_setting = Setting::pluck('monthly_distribution_point')->first();
        //全てのユーザーの配布ポイントを設定値に更新
        User::all()->map(function ($user) use ($distribution_point_setting) {
            $user->distribution_point = $distribution_point_setting;
            $user->save();
            return $user;
        });
        //laravel.logに記録
        Log::info('定期ポイント配布完了');
        return Command::SUCCESS;
    }
}