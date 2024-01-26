<?php

namespace App\Providers;

use App\Services\ConfigurationService;
use App\Services\FilesService;
use App\Services\LanguageService;
use App\Services\MastersService;
use App\Services\MasterTableService;
use App\Services\PagesService;
use App\Services\SeoService;
use App\Services\TranslateService;
use App\Services\UsersService;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Language', function($app) {
            return new LanguageService();
        });

        $this->app->singleton('Seo', function($app) {
            return new SeoService();
        });

        $this->app->singleton('Translate', function($app) {
            return new TranslateService();
        });

        $this->app->singleton('Configuration', function ($app) {
            return new ConfigurationService();
        });

        $this->app->singleton('MasterTable', function($app) {
            return new MasterTableService();
        });

        $this->app->singleton('Users', function($app) {
            return new UsersService();
        });

        $this->app->bind('FilesService', function ($app) {
            return new FilesService();
        });

        $this->app->singleton('PagesService', function($app) {
            return new PagesService($app->make(LanguageService::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Carbon::setLocale('es');
        setlocale(LC_ALL, 'es_ES');
    }
}
