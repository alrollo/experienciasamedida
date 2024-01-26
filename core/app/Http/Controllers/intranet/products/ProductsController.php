<?php

namespace App\Http\Controllers\intranet\products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductFamily;
use App\Rules\CheckId;
use App\Services\LanguageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    private $_languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->_languageService = $languageService;
    }

    public function get() {
        $query = ProductFamily::select('product_families.id', 'product_families.title', 'product_families.active');
        $query->orderBy('title', 'asc');
        $families = $query->get();

        $query = Product::select('products.id', 'products.title', 'products.active', 'products.family_id');
        $query->with('family')->orderBy('products.title', 'asc');
        $items = $query->get();

        return view('intranet/products/products-grid', ['items' => $items, 'families' => $families]);
    }

    public function getById($id) {
        $item = Product::where('id', $id)->with('creator', 'updater')->first();

        if ($item == null)
            abort(404);

        $languages = $this->_languageService->GetArray();
        $families = ProductFamily::select('product_families.id', 'product_families.title')->orderBy('title', 'asc')->get();
        return view('intranet/products/product-form', ['item' => $item, 'families' => $families, 'languages' => $languages]);
    }

    public function create() {
        $item = new Product();

        // Set defaults values
        $item->id = 0;
        $item->active = false;
        $item->creator = Auth::user();
        $item->updater = Auth::user();
        $item->created_at = Carbon::now();
        $item->updated_at = Carbon::now();

        $languages = $this->_languageService->GetArray();
        $families = ProductFamily::select('product_families.id', 'product_families.title')->orderBy('title', 'asc')->get();
        return view('intranet/products/product-form', ['item' => $item, 'families' => $families, 'languages' => $languages]);
    }

    public function set(Request $request)
    {
        $validateData = $request->validate([
            'id' =>'required|integer',
            'secureId' => [new CheckId($request->input('id'))],
            'title.es' => 'required',
            'family_id' => 'required'
        ]);

        // Get item to update
        $item = new Product();
        if ($request->input('id') != 0)
            $item = Product::find($request->input('id'));

        if ($item == null)
            abort(404);

        // Update item info
        $item->active = $request->input('active') == true;
        $item->family_id = $request->input('family_id');
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
            ->action([ProductsController::class, 'getById'], ['id' => $item->id])
            ->with('message.success', 'Se ha guardado correctamente la información');
    }

    public function delete($id) {
        $item = Product::find($id);
        if ($item == null)
        {
            return redirect()
                ->action([ProductsController::class, 'get'])
                ->with('message.error', 'No se ha podido eliminar el elemento indicado');
        }

        $item->delete();

        return redirect()->action([ProductsController::class, 'get'])->with('message.success', 'Se ha eliminado la información correctamente');
    }
}
