<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Config;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(Schema::hasTable('configs')){
            $livechat_id = Config::where('key', 'livechat_id')->first();
            view()->share('livechat_id', $livechat_id->value);

            $telegram_token = Config::where('key', 'telegram_token')->first();
            config(['telegram.bots.mybot.token' => $telegram_token->value]);
        }
    }
}
