<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFileRequest;
use App\Services\FilesService;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Validator;

class UploadFileController extends Controller
{
    private $_filesService = null;

    public function __construct(FilesService $filesService)
    {
        $this->_filesService = $filesService;
    }

    public function UploadFile(UploadFileRequest $request)
    {
        $chunk = $request->input('chunk') + 1;
        $chunks = $request->input('chunks');
        $model = $request->input('model');
        $id = $request->input('id');
        $type = $request->input('type');
        $tag = $request->input('tag');
        $finalPathForFile = strtolower($model).DIRECTORY_SEPARATOR.$id;

        try {
            // Upload part to temp path
            $fileStored = $this->_filesService->uploadChunkFileToTemp($request->file('file'));

            // if is the last chunk, add to database and process it
            if ($chunks == $chunk) {
                $fileMoved = $this->_filesService->moveFileFromTempTo($fileStored, $finalPathForFile);
                if ($fileMoved == null) {
                    return response()->json(['message' => 'No se ha podido subir correctamente el archivo'], 500);
                }

                $fileEntity = $this->_filesService->addUploadedFileToDatabase($fileMoved, $type, $model, $id, $tag);
                if ($fileEntity == null)
                    return response()->json(['message' => 'No se ha podido guardar el archivo en base de datos'], 500);

                $obj = $fileEntity;
                return response()->json(['message' => 'Se ha subido correctamente la imagen', 'data' => $obj], 200);
            }
        }
        catch (\Exception $error) {
            return response()->json(['message' => $error->getMessage(), 'trace' => $error->getTrace()], 500);
        }
    }

    public function uploadFileToTemp(Request $request)
    {
        $chunk = $request->input('chunk') + 1;
        $chunks = $request->input('chunks');
        $fileName = $request->input('name');

        if ($this->_filesService->uploadChunkFileToTemp('public', $request->file('file'), $fileName) == false)
        {
            return response()->json(['message' => 'No se ha podido subir el archivo'], 500);
        }
        else
        {
            if ($chunks == $chunk)
            {
                $obj = new \stdClass();
                $obj->name = $fileName;
                $obj->url = '/storage/temp/'.$fileName;
                return response()->json(['message' => 'Se ha subido correctamente la imagen', 'data' => $obj], 200);
            }
        }
    }



}
