<?php

namespace App\Http\Controllers\publico\auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show login form to the application.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        if (Auth::check())
            return redirect()->route('intranet.dashboard');
        else
            return view('public/auth/login');
    }

    /**
     * Handle a login request to the application.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function makeLogin(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = array();
        $credentials['email'] = $request->input('email');
        $credentials['password'] = $request->input('password');
        $credentials['active'] = true;
        $remember = ($request->input('remember') == 'on');
        if (Auth::attempt($credentials, $remember))
        {
            $user = Auth::user();
            $user->last_login = Carbon::now();
            $user->save();

            return redirect()->route('intranet.dashboard');
        }
        else
        {
            $error ="Usuario o contraeña incorrectos";
            return view('public/auth/login', compact('error'));
        }
    }

    /**
     * Handle a logout request to the application.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return view('public/auth/login');
    }
}
