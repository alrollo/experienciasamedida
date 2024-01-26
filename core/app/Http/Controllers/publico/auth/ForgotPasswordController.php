<?php

namespace App\Http\Controllers\publico\auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\intranet\membership\UsersController;
use App\Mail\AuthResetLink;
use App\Mail\AuthSendPassword;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForm(Request $request)
    {
        return view('public/auth/reset-password');
    }

    public function sendEmailReset(Request $request) {
        $validatedData = $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->input('email'))->first();


        if ($user == null) {
            Session::flash('message.error', 'No encontramos el usuario indicado');
            return view('public/auth/reset-password');
        }

        // Remove time outs resets passwords
        PasswordReset::where('email', $user->email)->delete();

        // Craete new reset password item
        $token = Str::random(64);
        $password_reset = PasswordReset::create(['email' => $user->email, 'token' => $token, 'created_at' => Carbon::now()]);
        Mail::to($password_reset->email)->send(new AuthResetLink($password_reset));

        Session::flash('message.success', 'Te hemos enviado un email con las instrucciones para resetear la contraseña');
        return view('public/auth/reset-password');
    }

    public function resetLink($token, $email) {
        $date_limit = Carbon::now()->subMinutes(60);
        $password = PasswordReset::where([['email', $email], ['token', $token], ['created_at', '>', $date_limit]])->first();

        if ($password == null) {
            return view('public/auth/invalid-link');
        } else {
            $new_password = Str::random(8);
            $user = User::where('email', $email)->first();
            $user->password = bcrypt($new_password);
            $user->save();

            PasswordReset::where([['email', $email], ['token', $token], ['created_at', '>', $date_limit]])->delete();

            Mail::to($user->email)->send(new AuthSendPassword($new_password));
            return view('public/auth/send-password');
        }
    }

    /**
     * Método que obtiene los mensajes de las variables de sesión
     */
    private function _getMessages() {
        $toReturn = [];
        $toReturn['danger'] = Session::get('messages.danger');
        $toReturn['warning'] = Session::get('messages.warning');
        $toReturn['success'] = Session::get('messages.success');

        return $toReturn;
    }
}
