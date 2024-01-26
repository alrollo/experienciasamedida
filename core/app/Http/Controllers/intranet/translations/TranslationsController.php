<?php

namespace App\Http\Controllers\intranet\translations;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use App\Rules\CheckId;
use App\Services\LanguageService;
use App\Services\TranslateService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TranslationsController extends Controller
{
    private $_languageService;
    private $_translateService;

    public function __construct(LanguageService $languageService, TranslateService  $translateService)
    {
        $this->_languageService = $languageService;
        $this->_translateService = $translateService;
    }

    public function get() {
        $query = Translation::select('translations.id', 'translations.mark', 'translations.translation');

        // Search

        $query->orderBy('translations.mark', 'asc');

        $items = $query->get();
        $languages = $this->_languageService->GetArray();
        return view('intranet/translations/translations-grid', ['items' => $items, 'languages' => $languages]);
    }

    public function getById($id) {
        $item = Translation::where('id', $id)->with('creator', 'updater')->first();

        if ($item == null)
            abort(404);

        $languages = $this->_languageService->GetArray();
        return view('intranet/translations/translation-form', ['item' => $item, 'languages' => $languages]);
    }

    public function getByIdXhr($id) {
        $item = Translation::where('id', $id)->first();
        return response()->json($item);
    }

    public function setXhr(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'secureId' => [new CheckId($request->input('id'))],
            'translation.es' => 'required'
        ]);

        if ($validator->fails())
        {
            return response()->json(['message' => 'No se ha podido guardar la información', 'data'=> $validator->errors()->all()], 422);
        }

        // Get item to update
        $item = Translation::find($request->input('id'));

        if ($item == null)
            abort(404);

        // Update item info
        $item->translation = collect($request->input('translation'))->map(function ($valor) { return $valor ?? ''; })->all();
        $item->updated_by = Auth::user()->id;
        $item->save();

        $this->_translateService->RefreshCache();

        return response()->json($item);
    }

    public function create() {
        $item = new Translation();

        // Set defaults values
        $item->id = 0;
        $item->creator = Auth::user();
        $item->updater = Auth::user();
        $item->created_at = Carbon::now();
        $item->updated_at = Carbon::now();

        $languages = $this->_languageService->GetArray();
        return view('intranet/translations/translation-form', ['item' => $item, 'languages' => $languages]);
    }

    public function set(Request $request)
    {
        $validateData = $request->validate([
            'id' =>'required|integer',
            'secureId' => [new CheckId($request->input('id'))],
            'translation.es' => 'required'
        ]);

        // Get item to update
        $item = new Translation();
        if ($request->input('id') != 0)
            $item = Translation::find($request->input('id'));

        if ($item == null)
            abort(404);

        // Update item info
        $item->translation = collect($request->input('translation'))->map(function ($valor) { return $valor ?? ''; })->all();
        $item->updated_by = Auth::user()->id;

        if (!$item->exists)
        {
            $item->created_by = Auth::user()->id;
        }

        $item->save();

        $this->_translateService->RefreshCache();

        return redirect()
            ->action([TranslationsController::class, 'get'])
            ->with('message.success', 'Se ha guardado correctamente la información');
    }

    public function delete($id) {
        $item = Translation::find($id);
        if ($item == null)
        {
            return redirect()
                ->action([TranslationsController::class, 'get'])
                ->with('message.error', 'No se ha podido eliminar el elemento indicado');
        }

        $item->delete();

        return redirect()->action([TranslationsController::class, 'get'])->with('message.success', 'Se ha eliminado la información correctamente');
    }
}
