<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $site_settings = \App\Models\Setting::pluck('value', 'key');
                view()->share('site_settings', $site_settings);
            }
        } catch (\Exception $e) {
            // Table might not exist yet during migration
        }
    }
}
