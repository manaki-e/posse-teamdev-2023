<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;

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
    protected $description = 'Peer Point配布';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            //配布ポイントの設定値を取得
            $distribution_point_setting = Setting::value('monthly_distribution_point');
            //全てのユーザーの配布ポイントを設定値に更新
            User::query()->update(['distribution_point' => $distribution_point_setting]);
            DB::commit();
            //laravel.logに記録
            Log::info('Peer Point配布完了');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Batch processing failed: ' . $e->getMessage());
            // Additional error handling or notification code can be added here...
            return Command::FAILURE;
        }
    }
}
