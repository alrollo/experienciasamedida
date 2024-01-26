<?php

namespace App\Http\Controllers\intranet\masters;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Services\MasterTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class OptionsController extends Controller
{
    private $_masterTableService;

    public function __construct(MasterTableService $masterTableService)
    {
        $this->_masterTableService = $masterTableService;
    }

    public function getById($master_id) {
        $items = Option::where('master_id', $master_id)->orderBy('order')->get();
        return response()->json($items);
    }

    public function set(Request $request, $master_id) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'option' => 'required|array',
        ]);

        if ($validator->fails())
        {
            return response()->json(['message' => 'No se ha podido guardar la información', 'data'=> $validator->errors()->all()], 422);
        }

        $item = new Option();
        if ($request->input('id') != 0)
            $item = Option::find($request->input('id'));

        if ($item == null)
            return response()->json(null, 404);

        foreach ($request->input('option') as $key => $value) {
            $item->setTranslation('option', $key, $value);
            $item->setTranslation('option_slug', $key, Str::slug($value));
        }

        if ($item->exists == false)
        {
            $item->master_id = $master_id;
            $item->order = $this->_getOrder($master_id);
        }
        $item->save();
        $this->_masterTableService->RefreshCache();

        return response()->json(null);
    }

    public function delete($master_id, $id) {
        $item = Option::where([['master_id', $master_id], ['id', $id]])->first();

        if ($item == null)
            return response()->json(null, 404);

        $item->delete();
        $this->_masterTableService->RefreshCache();

        return response()->json(null);
    }

    public function setOrder(Request $request, $master_id) {
        $validator = Validator::make($request->all(), [
            'order' => 'required|array',
        ]);

        if ($validator->fails())
        {
            return response()->json(['message' => 'No se ha podido guardar la información', 'data'=> $validator->errors()->all()], 422);
        }

        $items = Option::where('master_id', $master_id)->whereIn('id', $request->input('order'))->get();
        $order = 1;
        foreach ($request->input('order') as $idOrdered) {
            $item = $items->where('id', $idOrdered)->first();
            if ($item != null) {
                $item->order = $order++;
                $item->save();
            }
        }
        $this->_masterTableService->RefreshCache();

        return response()->json(null);

    }

    private function _getOrder($master_id) {
        $order = Option::where('master_id', $master_id)->max('order');

        if ($order == null)
            return 1;

        return ++$order;
    }
}
