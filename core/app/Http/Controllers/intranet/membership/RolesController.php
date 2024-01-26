<?php

namespace App\Http\Controllers\intranet\membership;

use App\Http\Controllers\Controller;
use App\Rules\CheckId;
use App\Services\FilesService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function get() {
        $query = Role::select('roles.id', 'roles.name_friendly');

        // Search
        $query->where('roles.name', '!=', 'master');

        $query->orderBy('name_friendly', 'asc');

        $items = $query->get();

        return view('intranet/membership/roles-grid', ['items' => $items]);
    }

    public function getById($id) {
        $item = Role::where([['id', $id], ['name', '!=', 'master']])->first();

        if ($item == null)
            abort(404);

        $permissions = Permission::all()->sortBy('name');
        return view('intranet/membership/role-form', ['item' => $item, 'permissions' => $permissions]);
    }

    public function create() {
        $item = new Role();

        // Set defaults values
        $item->id = 0;
        $item->created_at = Carbon::now();
        $item->updated_at = Carbon::now();

        $permissions = Permission::all()->sortBy('name');
        return view('intranet/membership/role-form', ['item' => $item, 'permissions' => $permissions]);
    }

    public function set(Request $request, FilesService $filesService)
    {
        $validateData = $request->validate([
            'id' =>'required|integer',
            'secureId' => [new CheckId($request->input('id'))],
            'name' => 'required',
            'name_friendly' => 'required',
            'permissions' => 'required|array|min:0'
        ]);

        // Get item to update
        $item = new Role();
        if ($request->input('id') != 0)
            $item = Role::find($request->input('id'));

        if ($item == null)
            abort(404);

        // Update item info
        $item->name = $request->input('name');
        $item->name_friendly = $request->input('name_friendly');

        // Sync permissions
        $item->syncPermissions($request->input('permissions'));
        $item->save();

        // Clear cache
        Artisan::call('cache:clear');

        return redirect()
            ->action([RolesController::class, 'get'])
            ->with('message.success', 'Se ha guardado correctamente la información');
    }

    public function delete($id) {
        $item = Role::find($id);
        if ($item == null)
        {
            return redirect()
                ->action([RolesController::class, 'get'])
                ->with('message.error', 'No se ha podido eliminar el elemento indicado');
        }

        $item->delete();

        // Clear cache
        Artisan::call('cache:clear');

        return redirect()->action([RolesController::class, 'get'])->with('message.success', 'Se ha elminado la información correctamente');
    }
}
