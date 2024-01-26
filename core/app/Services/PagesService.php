<?php

namespace App\Services;

use App\Models\Page;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Cache;
use App\Services\LanguageService;

class PagesService
{
    const CLAVE_CACHE = 'URL_PAGES';

    private LanguageService $_languageService;

    public function __construct(LanguageService $languageService) {
        $this->_languageService = $languageService;
    }

    public function RefreshCache() {
        $start = microtime(true);
        $pages = Page::select('id', 'url')->get();

        $dictionary_pages_id = [];
        foreach ($pages as $page) {
            if ($page->url) {
                foreach ($page->url as $url) {
                    if (array_key_exists($url, $dictionary_pages_id) === FALSE)
                        $dictionary_pages_id[$url] = $page->id;
                }
            }
        }

        Cache::put(self::CLAVE_CACHE, $dictionary_pages_id);

        $time_elapsed_secs = microtime(true) - $start;
        Debugbar::info("RefreshCache `PAGES` time: $time_elapsed_secs");
    }

    public function GetIdByUrl($url) {
        $start = microtime(true);
        if (Cache::has(self::CLAVE_CACHE) == false)
            self::RefreshCache();

        $pages = Cache::get(self::CLAVE_CACHE);

        $page_id = null;
        if (array_key_exists($url, $pages))
            $page_id = $pages[$url];

        $time_elapsed_secs = microtime(true) - $start;
        Debugbar::info("GetIdByUrl time: $time_elapsed_secs");
        return $page_id;
    }
}
