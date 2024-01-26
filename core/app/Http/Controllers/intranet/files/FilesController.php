<?php

namespace App\Http\Controllers\intranet\files;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Services\FilesService;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use Validator;

class FilesController extends Controller
{

    private $_filesService;

    public function __construct(FilesService $filesService)
    {
        $this->_filesService = $filesService;
    }

    public function getById(LanguageService $languageService, $id) {
        $item = File::select('name', 'description')->where('id', $id)->first();

        return response()->json($item);
    }

    public function set(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'array',
            'description' => 'array'
        ]);

        if ($validator->fails())
        {
            return response()->json(['message' => 'No se ha podido guardar la información', 'data'=> $validator->errors()->all()], 422);
        }

        $item = File::find($request->input('id'));
        if ($item == null)
            return response()->json(null, 404);

        // Save name translation
        foreach ($request->input('name') as $key => $value) {
            $item->setTranslation('name', $key, $value ?? '');
        }

        // Save description tranlation
        foreach ($request->input('description') as $key => $value) {
            $item->setTranslation('description', $key, $value ?? '');
        }
        $item->save();

        // Conform response
        $response = new \stdClass();
        $response->id = $item->id;
        $response->name = $item->getTranslations('name');
        $response->description = $item->getTranslations('description');
        $response->file_size = formatBytes($item->file_size, 2);
        return response()->json($response);
    }

    public function delete($id) {
        $file = File::where('id', $id)->first();

        if ($file == null)
            return response()->json(null, 404);

        // Check if file exists and delete if true
        if ($this->_filesService->fileExists($file)) {
            $this->_filesService->deleteFile($file);
        }

        // Delete file from DB
        $file->delete();

        return response()->json(null);
    }

    public function setOrder(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'order' => 'required|array',
        ]);

        if ($validator->fails())
        {
            return response()->json(['message' => 'No se ha podido guardar la información', 'data'=> $validator->errors()->all()], 422);
        }

        $items = File::where('attachable_id', $id)->whereIn('id', $request->input('order'))->get();
        $order = 1;
        foreach ($request->input('order') as $idOrdered) {
            $item = $items->where('id', $idOrdered)->first();
            if ($item != null) {
                $item->order = $order++;
                $item->save();
            }
        }

        return response()->json(null);

    }
}
