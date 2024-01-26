<?php

namespace App\Services;

use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Cache;

class UsersService
{
    const CLAVE_CACHE = 'USERS';


    public function __construct() {
    }

    public function RefreshCache() {
        $start = microtime(true);
        $users = User::select('id', 'name', 'email')->get();

        Cache::put(self::CLAVE_CACHE, $users);

        $time_elapsed_secs = microtime(true) - $start;
        Debugbar::info("RefreshCache `USERS` time: $time_elapsed_secs");
    }

    public function GetAll() {
        $start = microtime(true);
        if (Cache::has(self::CLAVE_CACHE) == false)
            self::RefreshCache();

        $users = Cache::get(self::CLAVE_CACHE);

        $time_elapsed_secs = microtime(true) - $start;
        Debugbar::info("GetUsers time: $time_elapsed_secs");
        return $users;
    }
}
