<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        View::composer('*', function ($view) {
            // Get the cached menu items
            $menuItems = Cache::remember('navbar_menu', 60 * 60 * 24, function () {
                return \App\Models\MenuItem::whereNull('parent_id')
                    ->with('children')
                    ->where('status', true)
                    ->orderBy('order')
                    ->get();
            });

            $view->with('globalMenuItems', $menuItems);

            // Get the cached footer links
            $footerLinks = Cache::remember('footer_links', 60 * 60 * 24, function () {
                return \App\Models\FooterLink::where('status', true)
                    ->orderBy('order')
                    ->get();
            });

            $view->with('footerLinks', $footerLinks);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
    }
}
