<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;


class ConfigurationService
{
    protected $Configuration = [];

    public function __construct()
    {
        $this->Configuration = Cache::rememberForever('configuration', function() {
            return Setting::get()->pluck('value', 'name')->toArray();
        });
    }

    public function get($key, $defaultValue = "")
    {
        if (array_key_exists($key, $this->Configuration))
            return $this->Configuration[$key];

        return $defaultValue;
    }


}
