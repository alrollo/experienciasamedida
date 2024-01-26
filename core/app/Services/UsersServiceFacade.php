<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class UsersServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Users';
    }
}
