<?php

namespace App\Http\Controllers\intranet\ftp;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Services\FilesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FtpController extends Controller
{
    private $_filesService;

    public function __construct(FilesService $filesService)
    {
        $this->_filesService = $filesService;
    }

    public function search(Request $request) {
        $search = $request->input('query');

        $query = File::select('id','file_name', 'file_type', 'file_size')
            ->where('attachable_type', 'App\Models\ftp');

        if (isset($search))
            $query->where('file_name', 'like', '%'.$search.'%');

        $filesCollection = $query->orderBy('file_name', 'asc')->get();

        $filesCollection = $filesCollection->map(function ($file) {
            $file->url = asset('storage/ftp/0/'. $file->file_name);
            $file->file_size = formatBytes($file->file_size, 2);
            return $file;
        });

        return response()->json($filesCollection);
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails())
        {
            return response()->json(['message' => 'No se ha podido eliminar la información', 'data'=> $validator->errors()->all()], 422);
        }

        $file = File::where('id', $request->input('id'))->first();

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
}
