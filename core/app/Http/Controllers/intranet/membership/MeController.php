<?php

namespace App\Http\Controllers\intranet\membership;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\CheckId;
use App\Services\FilesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeController extends Controller
{
    public function get() {
        $item = User::where('id', Auth::user()->id)->with('roles:name')->first();

        if ($item == null)
            abort(404);

        return view('intranet/membership/me-form', ['item' => $item]);
    }


    public function set(Request $request, FilesService $filesService)
    {
        $validateData = $request->validate([
            'id' =>'required|integer',
            'secureId' => [new CheckId($request->input('id'))],
            'name' => 'required',
            'email' => "required|email|unique:users,email,{$request->input('id')},id",
            'password' => 'nullable|required_if:id,==,0|confirmed'
        ]);

        // Get user to update
        $user = new User();
        if ($request->input('id') != 0)
            $user = User::find($request->input('id'));

        if ($user == null)
            abort(404);

        // Update user info
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->input('password'))
            $user->password = bcrypt($request->input('password'));

        if ($request->input('imageProfile') != '') {
            if ($filesService->moveTempFile('public', $request->input('imageProfile'), 'users'))
                $user->avatar = $request->input('imageProfile');
        }

        $user->save();

        return redirect()
            ->action([MeController::class, 'get'])
            ->with('message.success', 'Se ha modificado la información correctamente');
    }
}
