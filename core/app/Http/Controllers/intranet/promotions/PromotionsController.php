<?php

namespace App\Http\Controllers\intranet\promotions;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Rules\CheckId;
use App\Services\LanguageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PromotionsController extends Controller
{
    private $_languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->_languageService = $languageService;
    }

    public function get() {
        $query = Promotion::select('promotions.id', 'promotions.title', 'promotions.type_id', 'promotions.active');

        // Search

        $query->with('type:option')->orderBy('title', 'asc');

        $items = $query->get();

        return view('intranet/promotions/promotions-grid', ['items' => $items]);
    }

    public function getById($id) {
        $item = Promotion::where('id', $id)->with('creator', 'updater')->first();

        if ($item == null)
            abort(404);

        $languages = $this->_languageService->GetArray();
        return view('intranet/promotions/promotion-form', ['item' => $item, 'languages' => $languages]);
    }

    public function create() {
        $item = new Promotion();

        // Set defaults values
        $item->id = 0;
        $item->active = false;
        $item->creator = Auth::user();
        $item->updater = Auth::user();
        $item->created_at = Carbon::now();
        $item->updated_at = Carbon::now();

        $languages = $this->_languageService->GetArray();
        return view('intranet/promotions/promotion-form', ['item' => $item, 'languages' => $languages]);
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
        $item = new Promotion();
        if ($request->input('id') != 0)
            $item = Promotion::find($request->input('id'));

        if ($item == null)
            abort(404);

        // Update item info
        $item->active = $request->input('active') == true;
        $item->featured = $request->input('featured') == true;
        $item->type_id = $request->input('type_id');
        $item->dateTime = Carbon::createFromFormat('d/m/Y H:i', $request->input('dateTime'));
        $item->title = collect($request->input('title'))->map(function ($valor) { return $valor ?? ''; })->all();

        $title_slug = [];
        foreach ($request->input('title_slug') as $key => $value) {
            if ($value == '')
                $title_slug[$key] = Str::slug($item->translate('title', $key, false));
            else
                $title_slug[$key] = Str::slug($value);
        }
        $item->title_slug = collect($title_slug)->map(function ($valor) { return $valor ?? ''; })->all();

        $item->summary = collect($request->input('summary'))->map(function ($valor) { return $valor ?? ''; })->all();
        $item->description = collect($request->input('description'))->map(function ($valor) { return $valor ?? ''; })->all();
        $item->updated_by = Auth::user()->id;

        if (!$item->exists)
        {
            $item->created_by = Auth::user()->id;
        }

        $item->save();

        return redirect()
            ->action([PromotionsController::class, 'getById'], ['id' => $item->id])
            ->with('message.success', 'Se ha guardado correctamente la información');
    }

    public function delete($id) {
        $item = Promotion::find($id);
        if ($item == null)
        {
            return redirect()
                ->action([PromotionsController::class, 'get'])
                ->with('message.error', 'No se ha podido eliminar el elemento indicado');
        }

        $item->delete();

        return redirect()->action([PromotionsController::class, 'get'])->with('message.success', 'Se ha eliminado la información correctamente');
    }
}
