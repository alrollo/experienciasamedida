<?php

namespace App\Http\Controllers\intranet\pages;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Module;
use App\Models\Page;
use App\Rules\CheckId;
use App\Services\FilesService;
use App\Services\LanguageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ModulesController extends Controller
{
    private $_languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->_languageService = $languageService;
    }

    public function getById($page_id, $id) {
        $page = Page::where('id', $page_id)->first();
        $item = Module::where([['page_id', $page_id], ['id', $id]])->with('creator', 'updater')->first();

        if ($page == null || $item == null)
            abort(404);

        $languages = $this->_languageService->GetArray();
        return view('intranet/pages/module-form', ['page' => $page, 'item' => $item, 'languages' => $languages]);
    }

    public function create(LanguageService $languageService, $page_id) {
        $page = Page::where('id', $page_id)->first();

        if ($page == null)
            abort(404);

        $item = new Module();

        // Set defaults values
        $item->id = 0;
        $item->active = false;
        $item->blocked = false;
        $item->creator = Auth::user();
        $item->updater = Auth::user();
        $item->created_at = Carbon::now();
        $item->updated_at = Carbon::now();

        $languages = $languageService->GetArray();
        return view('intranet/pages/module-form', ['page' => $page, 'item' => $item, 'languages' => $languages]);
    }

    public function set(Request $request, $page_id)
    {
        $validateData = $request->validate([
            'id' =>'required|integer',
            'secureId' => [new CheckId($request->input('id'))],
            'name' => 'required'
        ]);

        $page = Page::find($page_id);
        if ($page == null)
            abort(404);

        // Get page to update
        $module = new Module();
        if ($request->input('id') != 0)
            $module = Module::find($request->input('id'));

        if ($module == null)
            abort(404);

        // Update page info
        $module->page_id = $page_id;
        $module->active = $request->input('active') == true;
        $module->blocked = $request->input('blocked') == true;
        $module->name = $request->input('name');
        $module->content = $request->input('content');

        $module->updated_by = Auth::user()->id;
        if (!$module->exists)
        {
            $module->created_by = Auth::user()->id;
        }

        $module->save();

        return redirect()
            ->action([PagesController::class, 'getById'], ['id' => $page->id])
            ->with('message.success', 'Se ha guardado correctamente la información');
    }

    public function delete(Request $request, $page_id, $id)
    {
        $page = Page::where('id', $page_id)->first();
        $item = Module::where([['page_id', $page_id], ['id', $id]])->with('creator', 'updater')->first();

        if ($item == null)
        {
            return redirect()
                ->action([PagesController::class, 'getById'], ['id' => $page->id])
                ->with('message.error', 'No se ha podido eliminar el elemento indicado');
        }

        $item->delete();

        return redirect()->action([PagesController::class, 'getById'], ['id' => $page->id])->with('message.success', 'Se ha eliminado la información correctamente');
    }

    public function setOrderXhr(Request $request, $page_id){
        $validator = Validator::make($request->all(), [
            'order' => 'required|array',
            'order.*' => 'integer'
        ]);

        if ($validator->fails())
        {
            return response()->json(['message' => 'No se ha podido guardar la información', 'data'=> $validator->errors()->all()], 422);
        }

        $idsOrdered = $request->input('order');

        $i = 1;
        foreach ($idsOrdered as $id)
        {
            $module = Module::where([['page_id', $page_id], ['id', $id]])->first();
            if ($module != null)
            {
                $module->order = $i;
                $module->save();
                $i++;
            }
        }
        return response()->json(['message' => 'Se ha guardado la información correctamente'], 200);
    }
}
