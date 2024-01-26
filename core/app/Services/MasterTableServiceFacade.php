<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class MasterTableServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MasterTable';
    }
}
