<?php

namespace App\Http\Controllers\intranet\masters;

use App\Http\Controllers\Controller;
use App\Models\Master;
use App\Rules\CheckId;
use App\Services\FilesService;
use App\Services\LanguageService;
use App\Services\MasterTableService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MastersController extends Controller
{
    private $_masterTableService;

    public function __construct(MasterTableService $masterTableService)
    {
        $this->_masterTableService = $masterTableService;
    }

    public function get() {
        $query = Master::select('masters.id', 'masters.name', 'masters.description');

        // Search
        $query->orderBy('name', 'asc');

        $items = $query->get();

        return view('intranet/masters/masters-grid', ['items' => $items]);
    }

    public function getById(LanguageService $languageService, $id) {
        $item = Master::where('id', $id)->with('creator', 'updater')->first();

        if ($item == null)
            abort(404);

        return view('intranet/masters/master-form', ['item' => $item]);
    }

    public function create() {
        $item = new Master();

        // Set defaults values
        $item->id = 0;
        $item->creator = Auth::user();
        $item->updater = Auth::user();
        $item->created_at = Carbon::now();
        $item->updated_at = Carbon::now();

        return view('intranet/masters/master-form', ['item' => $item]);
    }

    public function set(Request $request, FilesService $filesService)
    {
        $validateData = $request->validate([
            'id' =>'required|integer',
            'secureId' => [new CheckId($request->input('id'))],
            'name' => 'required'
        ]);

        // Get table master to update
        $item = new Master();
        if ($request->input('id') != 0)
            $item = Master::find($request->input('id'));

        if ($item == null)
            abort(404);

        // Update table master info
        $item->name = $request->input('name');
        $item->name_slug = Str::slug($request->input('name'), "_");
        $item->description = $request->input('description');
        $item->updated_by = Auth::user()->id;

        if (!$item->exists)
        {
            $item->created_by = Auth::user()->id;
        }

        $item->save();
        $this->_masterTableService->RefreshCache();

        return redirect()
            ->action([MastersController::class, 'getById'], ['id' => $item->id])
            ->with('message.success', 'Se ha guardado correctamente la información');
    }

    public function delete($id) {
        $item = Master::find($id);
        if ($item == null)
        {
            return redirect()
                ->action([MastersController::class, 'get'])
                ->with('message.error', 'No se ha podido eliminar el elemento indicado');
        }

        $item->delete();
        $this->_masterTableService->RefreshCache();

        return redirect()->action([MastersController::class, 'get'])->with('message.success', 'Se ha eliminado la información correctamente');
    }
}
