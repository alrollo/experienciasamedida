<?php

namespace App\Http\Controllers\intranet\faqs;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Rules\CheckId;
use App\Services\LanguageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FaqsController extends Controller
{
    private $_languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->_languageService = $languageService;
    }

    public function get() {
        $query = Faq::select('faqs.id', 'faqs.title', 'faqs.type_id', 'faqs.active');

        // Search

        $query->with('type:option')->orderBy('title', 'asc');

        $items = $query->get();

        return view('intranet/faqs/faqs-grid', ['items' => $items]);
    }

    public function getById($id) {
        $item = Faq::where('id', $id)->with('creator', 'updater')->first();

        if ($item == null)
            abort(404);

        $languages = $this->_languageService->GetArray();
        return view('intranet/faqs/faq-form', ['item' => $item, 'languages' => $languages]);
    }

    public function create() {
        $item = new Faq();

        // Set defaults values
        $item->id = 0;
        $item->active = false;
        $item->creator = Auth::user();
        $item->updater = Auth::user();
        $item->created_at = Carbon::now();
        $item->updated_at = Carbon::now();

        $languages = $this->_languageService->GetArray();
        return view('intranet/faqs/faq-form', ['item' => $item, 'languages' => $languages]);
    }

    public function set(Request $request)
    {
        $validateData = $request->validate([
            'id' =>'required|integer',
            'secureId' => [new CheckId($request->input('id'))],
            'title.es' => 'required',
            'dateTime' => 'date_format:"d/m/Y H:i"'
        ]);

        // Get item to update
        $item = new Faq();
        if ($request->input('id') != 0)
            $item = Faq::find($request->input('id'));

        if ($item == null)
            abort(404);

        // Update item info
        $item->active = $request->input('active') == true;
        $item->type_id = $request->input('type_id');
        $item->title = collect($request->input('title'))->map(function ($valor) { return $valor ?? ''; })->all();
        $item->title_slug = collect($request->input('title'))->map(function ($valor) { return Str::slug($valor); })->all();
        $item->summary = collect($request->input('summary'))->map(function ($valor) { return $valor ?? ''; })->all();
        $item->description = collect($request->input('description'))->map(function ($valor) { return $valor ?? ''; })->all();
        $item->updated_by = Auth::user()->id;

        if (!$item->exists)
        {
            $item->created_by = Auth::user()->id;
        }

        $item->save();

        return redirect()
            ->action([FaqsController::class, 'getById'], ['id' => $item->id])
            ->with('message.success', 'Se ha guardado correctamente la información');
    }

    public function delete($id) {
        $item = Faq::find($id);
        if ($item == null)
        {
            return redirect()
                ->action([FaqsController::class, 'get'])
                ->with('message.error', 'No se ha podido eliminar el elemento indicado');
        }

        $item->delete();

        return redirect()->action([FaqsController::class, 'get'])->with('message.success', 'Se ha eliminado la información correctamente');
    }
}
