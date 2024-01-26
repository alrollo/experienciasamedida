<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class TranslateServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Translate';
    }
}
