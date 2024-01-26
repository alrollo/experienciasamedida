<?php

namespace App\Services;

use App\Models\Language;
use Illuminate\Support\Facades\Cache;


class LanguageService
{
    const CLAVE_CACHE = 'LANGUAGES';

    public function RefreshCache() {
        $languages = collect(Language::where('active', true)->get());
        Cache::put(self::CLAVE_CACHE, $languages);
    }

    /**
     * @return array
     */
    public function GetArray() : array
    {
        if (Cache::has(self::CLAVE_CACHE) == false)
            self::RefreshCache();

        $languages = Cache::get(self::CLAVE_CACHE);

        if ($languages == null)
            return [];

        $langs = $languages->pluck('language')->toArray();
        return $langs;
    }

    /**
     * @return Language[]|\Illuminate\Database\Eloquent\Collection
     */
    public function Get() : array
    {
        if (Cache::has(self::CLAVE_CACHE) == false)
            self::RefreshCache();

        $languages = Cache::get(self::CLAVE_CACHE);
        return $languages;
    }
}
