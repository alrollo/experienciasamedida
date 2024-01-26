<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt', ['except' => []]);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }
}
