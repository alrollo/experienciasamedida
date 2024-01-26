<?php

namespace App\Services;

use App\Models\Master;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Cache;

class MasterTableService
{
    const CLAVE_CACHE = 'MASTERS';


    public function __construct() {
    }

    public function RefreshCache() {
        $start = microtime(true);
        $masters = Master::select('id', 'name', 'name_slug')->with('options:id,master_id,option,option_slug,order')->get();

        Cache::put(self::CLAVE_CACHE, $masters);

        $time_elapsed_secs = microtime(true) - $start;
        Debugbar::info("RefreshCache `MASTERS` time: $time_elapsed_secs");
    }

    public function GetAll() {
        $start = microtime(true);
        if (Cache::has(self::CLAVE_CACHE) == false)
            self::RefreshCache();

        $masters = Cache::get(self::CLAVE_CACHE);

        $time_elapsed_secs = microtime(true) - $start;
        Debugbar::info("GetMaster time: $time_elapsed_secs");
        return $masters;
    }

    public function Get($name_slug) {
        $start = microtime(true);
        if (Cache::has(self::CLAVE_CACHE) == false)
            self::RefreshCache();

        $masters = Cache::get(self::CLAVE_CACHE);

        $master = $masters->where('name_slug', $name_slug)->first();

        $time_elapsed_secs = microtime(true) - $start;
        Debugbar::info("GetMaster time: $time_elapsed_secs");
        return $master ?? new Master();
    }
}
