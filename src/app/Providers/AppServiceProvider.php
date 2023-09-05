<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        URL::forceRootUrl(env('APP_URL'));
        //ローカル環境かリモート環境(codespaces,本番環境)で開発するかで条件分岐
        if(env('APP_ENV') !== 'local'){
            URL::forceScheme('https');
        }
    }
}
