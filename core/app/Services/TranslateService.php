<?php

namespace App\Services;

use App\Models\Translation;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Cache;

class TranslateService
{
    const CLAVE_CACHE = 'TRANSLATIONS';
    private $_translations = null;

    public function __construct()
    {
        $start = microtime(true);

        if (Cache::has(self::CLAVE_CACHE)) {
            $this->_translations = Cache::get(self::CLAVE_CACHE);
            $time_elapsed_secs = (microtime(true) - $start) * 1000;
            Debugbar::info("Get from cache `TRANSLATE` time: $time_elapsed_secs");
        } else {
            $this->_translations = Translation::select('mark', 'translation')->get();
            Cache::put(self::CLAVE_CACHE, $this->_translations);

            $time_elapsed_secs = (microtime(true) - $start) * 1000;
            Debugbar::info("RefreshCache `TRANSLATE` time: $time_elapsed_secs");
        }
    }

    public function RefreshCache() {
        $start = microtime(true);

        $translations = Translation::select('mark', 'translation')->get();
        Cache::put(self::CLAVE_CACHE, $translations);

        $time_elapsed_secs = (microtime(true) - $start) * 1000;
        Debugbar::info("RefreshCache `TRANSLATE` time: $time_elapsed_secs");
    }

    /**
     * @param string $key
     * @param string|null $default
     */
    public function Get(string $key, string $default = null) {
        $start = microtime(true);

        $translation = $this->_translations->where('mark', $key)->first();

        if ($translation == null) {
            $aux = Translation::create(['mark' => $key]);
            $this->_translations->push($aux);
            Cache::put(self::CLAVE_CACHE, $this->_translations);

            $time_elapsed_secs = (microtime(true) - $start) * 1000;
            Debugbar::info("Set translation `$key` time: $time_elapsed_secs");

            return $key;
        }

        $toReturn = $translation->getTranslation('translation', app()->getLocale());

        $time_elapsed_secs = (microtime(true) - $start) * 1000;
        Debugbar::info("Get translation `$key` time: $time_elapsed_secs");

        if ($toReturn == '')
            return $default ?? $key;

        return $toReturn;
    }
}
