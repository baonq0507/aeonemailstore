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
            view()->share('livechat_id', $livechat_id ? $livechat_id->value : null);

            $telegram_token = Config::where('key', 'telegram_token')->first();

            config(['telegram.bots.mybot.token' => $telegram_token ? $telegram_token->value : null]);

            $imageNotification = Config::where('key', 'anh_thong_bao')->first();
            view()->share('imageNotification', $imageNotification ? $imageNotification->value : null);

            $app_name = Config::where('key', 'app_name')->first();
            config(['app.name' => $app_name ? $app_name->value : 'App']);

            $app_description = Config::where('key', 'app_description')->first();
            config(['app.description' => $app_description ? $app_description->value : 'App']);
        }
    }
}
