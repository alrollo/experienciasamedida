<?php

namespace App\Http\Controllers\intranet\membership;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\CheckId;
use App\Services\FilesService;
use App\Services\UsersService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Validator;
class UsersController extends Controller
{
    private $_usersService;

    public function __construct(UsersService $usersService)
    {
        $this->_usersService = $usersService;
    }

    public function get() {
        $query = User::select('users.id', 'users.name', 'users.email', 'users.active');

        // Search

        // Prevent show master users
        $query->join('model_has_roles', 'model_has_roles.model_id', 'users.id');
        $query->join('roles', 'roles.id', 'model_has_roles.role_id');
        $query->where('roles.name', '!=', 'master');

        $query->with('roles:name_friendly');
        $query->orderBy('name', 'asc');

        $items = $query->get();

        return view('intranet/membership/users-grid', ['items' => $items]);
    }

    public function getById($id) {
        $item = User::where('id', $id)->with('roles:name', 'creator', 'updater')->first();

        if ($item == null || in_array('master', $item->roles->pluck('name')->toArray()))
            abort(404);

        $roles = Role::where([['name', '!=', 'master']])->orderBy('name')->get();
        return view('intranet/membership/users-form', ['item' => $item, 'roles' => $roles]);
    }

    public function create() {
        $item = new User();

        // Set defaults values
        $item->id = 0;
        $item->active = false;
        $item->avatar = 'default.jpg';
        $item->creator = Auth::user();
        $item->updater = Auth::user();
        $item->created_at = Carbon::now();
        $item->updated_at = Carbon::now();

        $roles = Role::where([['name', '!=', 'master']])->orderBy('name')->get();
        return view('intranet/membership/users-form', ['item' => $item, 'roles' => $roles]);
    }

    public function set(Request $request, FilesService $filesService)
    {
        $validateData = $request->validate([
            'id' =>'required|integer',
            'secureId' => [new CheckId($request->input('id'))],
            'name' => 'required',
            'email' => "required|email|unique:users,email,{$request->input('id')},id",
            'roles' => 'required|array|min:1',
            'password' => 'nullable|required_if:id,==,0|confirmed'
        ]);

        // Get user to update
        $user = new User();
        if ($request->input('id') != 0)
            $user = User::find($request->input('id'));

        if ($user == null)
            abort(404);

        $roles = Arr::where($request->input('roles'), function ($value, $key) {
            return $value != 'master';
        });

        // Update user info
        $user->active = $request->input('active') == true;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->input('password'))
            $user->password = bcrypt($request->input('password'));

        if ($request->input('imageProfile') != '') {
            if ($filesService->moveTempFile('public', $request->input('imageProfile'), 'users'))
                $user->avatar = $request->input('imageProfile');
        }

        // Sync roles
        $user->syncRoles($roles);
        $user->save();

        // Clear cache
        Artisan::call('cache:clear');

        return redirect()
            ->action([UsersController::class, 'get'])
            ->with('message.success', 'Se ha guardado correctamente la información');
    }

    public function delete($id) {
        if (Auth::user()->id == $id) {
            return redirect()
                ->action([UsersController::class, 'get'])
                ->with('message.error', 'No se puede eliminar el usuario actual');
        }

        $item = User::find($id);
        if ($item == null)
        {
            return redirect()
                ->action([UsersController::class, 'get'])
                ->with('message.error', 'No se ha podido eliminar el elemento indicado');
        }

        // Delete image if exists
        if ($item->avatar && $item->avatar != 'default.jpg' && Storage::disk('public')->exists('users'.DIRECTORY_SEPARATOR.$item->avatar)){
            Storage::disk('public')->delete('users'.DIRECTORY_SEPARATOR.$item->avatar);
        }

        $item->delete();

        // Clear cache
        Artisan::call('cache:clear');

        return redirect()->action([UsersController::class, 'get'])->with('message.success', 'Se ha elminado la información correctamente');
    }

    public function impersonate(Request $request) {
        $request->validate([
            'impersonate_id' =>'required|integer'
        ]);

        $impersonateUserId = $request->input('impersonate_id');
        $impersonateUser = User::findOrFail($impersonateUserId);
        if ($impersonateUserId != Auth::user()->id && $impersonateUser) {
            Auth::user()->impersonate($impersonateUser);
            return redirect()->route('intranet.dashboard');
        }

        return redirect()->route('intranet.dashboard');
    }

    public function leaveImpersonate() {
        Auth::user()->leaveImpersonation();
        return redirect()->route('intranet.dashboard');
    }
}
