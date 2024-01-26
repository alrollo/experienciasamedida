<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class SeoServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Seo';
    }
}
