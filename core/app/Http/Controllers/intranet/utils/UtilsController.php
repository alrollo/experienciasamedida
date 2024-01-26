<?php

namespace App\Http\Controllers\intranet\utils;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class UtilsController extends Controller
{
    public function clearViewsCache()
    {
        Artisan::call('view:clear');
        return response()->json(['message' => 'Se ha reseteado la cache correctamente', 'status' => true], 200);
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        return response()->json(['message' => 'Se ha reseteado la cache correctamente', 'status' => true], 200);
    }

    public function createLinkStorage()
    {
        try {
            symlink('core/storage/app/public', 'storage');
            return response()->json(['message' => 'Se ha creado el link correctamente', 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'No se ha podido crear el link', 'status' => false], 500);
        }
    }

    public function emptyTempFolders() {
        $disks = ['local', 'public'];
        $size = 0;
        $number_of_files = 0;
        foreach ($disks as $disk) {
            $files = Storage::disk($disk)->files('temp');

            foreach ($files as $file) {
                $number_of_files++;
                $size += Storage::disk($disk)->size($file);
                Storage::disk($disk)->delete($file);
            }
        }

        return response()->json(['message' => "Archivos eliminados: <b>{$number_of_files}</b><br>Espacio liberado: <b>".formatBytes($size, 2)."</b>", 'status' => true], 200);

    }

}
