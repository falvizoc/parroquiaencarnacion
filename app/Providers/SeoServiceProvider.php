<?php

namespace App\Providers;

use App\Services\SeoService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SeoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SeoService::class, function () {
            return new SeoService();
        });
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('seo', app(SeoService::class));
        });
    }
}
