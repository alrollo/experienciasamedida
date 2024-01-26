<?php

namespace App\Services;

use App\Models\Seo;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;


class SeoService
{
    const CLAVE_CACHE = 'SEO';

    public function RefreshCache() {
        $languages = collect(Seo::get());
        Cache::put(self::CLAVE_CACHE, $languages);
    }

    public function Get() {
        $urlPath = Request::path();

        if (Cache::has(self::CLAVE_CACHE) == false)
            self::RefreshCache();

        Debugbar::log('El idioma es '.app()->getLocale());
        $seoCollection = Cache::get(self::CLAVE_CACHE);
        $seo = $seoCollection->where('url', $urlPath)->where('language', app()->getLocale())->first();
        return $seo ?? new Seo();
    }
}
