<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class LanguageServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Language';
    }
}
