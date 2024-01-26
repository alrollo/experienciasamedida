<?php

namespace App\Http\Controllers\intranet\reviews;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ServiceFamily;
use App\Rules\CheckId;
use App\Services\LanguageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    private $_languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->_languageService = $languageService;
    }

    public function get() {
        $query = Review::select('reviews.id', 'reviews.active', 'reviews.title', 'reviews.dateTime', 'reviews.experiencia_id');

        // Search

        $query->orderBy('reviews.dateTime', 'desc');

        $items = $query->with('experiencia')->get();

        return view('intranet/reviews/reviews-grid', ['items' => $items]);
    }

    public function getById($id) {
        $item = Review::where('id', $id)->with('creator', 'updater')->first();

        if ($item == null)
            abort(404);

        $languages = $this->_languageService->GetArray();
        $experiencias = ServiceFamily::select('service_families.id', 'service_families.title')->orderBy('title', 'asc')->get();
        return view('intranet/reviews/review-form', ['item' => $item, 'languages' => $languages, 'experiencias' => $experiencias]);
    }

    public function create() {
        $item = new Review();

        // Set defaults values
        $item->id = 0;
        $item->active = false;
        $item->creator = Auth::user();
        $item->updater = Auth::user();
        $item->created_at = Carbon::now();
        $item->updated_at = Carbon::now();

        $languages = $this->_languageService->GetArray();
        $experiencias = ServiceFamily::select('service_families.id', 'service_families.title')->orderBy('title', 'asc')->get();
        return view('intranet/reviews/review-form', ['item' => $item, 'languages' => $languages, 'experiencias' => $experiencias]);
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
        $item = new Review();
        if ($request->input('id') != 0)
            $item = Review::find($request->input('id'));

        if ($item == null)
            abort(404);

        // Update item info
        $item->active = $request->input('active') == true;
        $item->dateTime = Carbon::createFromFormat('d/m/Y H:i', $request->input('dateTime'));
        $item->title = collect($request->input('title'))->map(function ($valor) { return $valor ?? ''; })->all();
        $item->summary = collect($request->input('summary'))->map(function ($valor) { return $valor ?? ''; })->all();
        $item->experiencia_id = $request->input('experiencia_id');
        $item->updated_by = Auth::user()->id;

        if (!$item->exists)
        {
            $item->created_by = Auth::user()->id;
        }

        $item->save();

        return redirect()
            ->action([ReviewsController::class, 'getById'], ['id' => $item->id])
            ->with('message.success', 'Se ha guardado correctamente la información');
    }

    public function delete($id) {
        $item = Review::find($id);
        if ($item == null)
        {
            return redirect()
                ->action([ReviewsController::class, 'get'])
                ->with('message.error', 'No se ha podido eliminar el elemento indicado');
        }

        $item->delete();

        return redirect()->action([ReviewsController::class, 'get'])->with('message.success', 'Se ha eliminado la información correctamente');
    }
}
