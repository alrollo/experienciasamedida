<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class ConfigurationServiceFacade extends  Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Configuration';
    }
}
