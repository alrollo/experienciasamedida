<?php

namespace App\Http\Controllers\intranet\pages;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Rules\CheckId;
use App\Services\FilesService;
use App\Services\LanguageService;
use App\Services\PagesService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class PagesController extends Controller
{
    private $_pagesService;
    private $_languageService;

    public function __construct(PagesService $pagesService, LanguageService $languageService)
    {
        $this->_pagesService = $pagesService;
        $this->_languageService = $languageService;
    }

    public function get() {
        $query = Page::select('pages.id', 'pages.name', 'pages.url', 'pages.active');

        // Search

        $query->orderBy('name', 'asc');

        $items = $query->get();

        return view('intranet/pages/pages-grid', ['items' => $items]);
    }

    public function getById($id) {
        $item = Page::where('id', $id)->with('modules', 'creator', 'updater')->first();

        if ($item == null)
            abort(404);

        $roles = Role::where([['name', '!=', 'master']])->orderBy('name')->get();
        $languages = $this->_languageService->GetArray();
        return view('intranet/pages/page-form', ['item' => $item, 'roles' => $roles, 'languages' => $languages]);
    }

    public function create() {
        $item = new Page();

        // Set defaults values
        $item->id = 0;
        $item->active = false;
        $item->url = [];
        $item->creator = Auth::user();
        $item->updater = Auth::user();
        $item->created_at = Carbon::now();
        $item->updated_at = Carbon::now();

        $roles = Role::where([['name', '!=', 'master']])->orderBy('name')->get();
        $languages = $this->_languageService->GetArray();
        return view('intranet/pages/page-form', ['item' => $item, 'roles' => $roles, 'languages' => $languages]);
    }

    public function set(Request $request)
    {
        $validateData = $request->validate([
            'id' =>'required|integer',
            'secureId' => [new CheckId($request->input('id'))],
            'name' => 'required',
            'url.*' => 'required|regex:/(^([\/_-a-zA-z0-9]+)?$)/u'
        ],
        [
            'url.regex' => 'La url no es válida'
        ]);

        // Get page to update
        $page = new Page();
        if ($request->input('id') != 0)
            $page = Page::find($request->input('id'));

        if ($page == null)
            abort(404);

        // Update page info
        $page->active = $request->input('active') == true;
        $page->name = $request->input('name');
        if (Auth::user()->can('pages.edit_urls'))
            $page->url = $request->input('url');
        $page->updated_by = Auth::user()->id;

        if (!$page->exists)
        {
            $page->created_by = Auth::user()->id;
        }

        $page->save();

        $this->_pagesService->RefreshCache();

        return redirect()
            ->action([PagesController::class, 'getById'], ['id' => $page->id])
            ->with('message.success', 'Se ha guardado correctamente la información');
    }

    public function delete($id) {
        $item = Page::find($id);
        if ($item == null)
        {
            return redirect()
                ->action([PagesController::class, 'get'])
                ->with('message.error', 'No se ha podido eliminar el elemento indicado');
        }

        $item->delete();

        $this->_pagesService->RefreshCache();

        return redirect()->action([PagesController::class, 'get'])->with('message.success', 'Se ha eliminado la información correctamente');
    }
}
