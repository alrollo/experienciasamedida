<?php

namespace App\Http\Controllers\intranet\seo;

use App\Http\Controllers\Controller;
use App\Models\Seo;
use App\Services\SeoService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SeoController extends Controller
{
    private $_seoService;

    public function __construct(SeoService $seoService)
    {
        $this->_seoService = $seoService;
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'url' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['message' => 'No se ha podido guardar la información', 'data'=> $validator->errors()->all()], 422);
        }

        $url = $request->input('url');
        $item = Seo::where([['url', $url], ['language', \app()->getLocale()]])->first();
        if ($item == null) {
            $item = new Seo();
            $item->url = $url;
            $item->language = App::getLocale();
        }

        $item->title  = $request->input('title');
        $item->description = $request->input('description');
        $item->keywords = $request->input('keywords');

        $item->updated_by = Auth::user()->id;
        if ($item->exists == false)
            $item->created_by = Auth::user()->id;

        $item->save();
        $this->_seoService->RefreshCache();

        return response()->json(null);
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'url' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['message' => 'No se ha podido guardar la información', 'data'=> $validator->errors()->all()], 422);
        }

        $url = $request->input('url');
        $item = Seo::where([['url', $url], ['language', \app()->getLocale()]])->delete();
        $this->_seoService->RefreshCache();

        return response()->json(null);
    }
}
