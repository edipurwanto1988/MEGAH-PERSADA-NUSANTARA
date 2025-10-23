<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\CompanyProfile;
use App\Models\Setting;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share company profile data with all views
        View::composer(['layouts.web', 'web-layout'], function ($view) {
            $companyProfile = CompanyProfile::first();
            $view->with('companyProfile', $companyProfile);
        });

        // Share SEO settings with all views
        View::composer(['layouts.web', 'web-layout'], function ($view) {
            $seoSettings = [
                'og_title' => setting('og_title'),
                'og_description' => setting('og_description'),
                'og_image' => setting('og_image'),
                'og_url' => setting('og_url'),
                'og_site_name' => setting('og_site_name'),
                'twitter_title' => setting('twitter_title'),
                'twitter_description' => setting('twitter_description'),
                'twitter_image' => setting('twitter_image'),
                'meta_title' => setting('meta_title'),
                'meta_description' => setting('meta_description'),
                'meta_keywords' => setting('meta_keywords'),
            ];
            $view->with('seoSettings', $seoSettings);
        });
    }
}