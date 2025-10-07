<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\CompanyProfile;
use App\Models\Setting;

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
        // Share company profile with all views using web layout
        View::composer(['layouts.web', 'components.web-layout'], function ($view) {
            $companyProfile = CompanyProfile::first();
            $view->with('companyProfile', $companyProfile);
        });
        
        // Create a global setting helper function
        if (!function_exists('setting')) {
            function setting($key, $default = null) {
                $setting = Setting::where('key', $key)->first();
                return $setting ? $setting->value : $default;
            }
        }
    }
}
