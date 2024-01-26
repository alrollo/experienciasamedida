<?php

namespace App\Services;

use Exception;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class FilesService
{
    private string $disk = 'public';

    public function __construct() {}

    public function setDisk($valor) { $this->disk = $valor; }
    public function getDisk(): string { return $this->disk; }

    /**
     * Move file from temp folder to indicated path
     * @param File $fileStored File stored
     * @param string $path Final path for the file
     * @return File
     * @throws Exception
     */
    public function moveFileFromTempTo(File $fileStored, string $path): ?File
    {
        if (Storage::disk($this->disk)->exists($path) === false)
            Storage::disk($this->disk)->makeDirectory($path);

        $tempPath = 'temp'.DIRECTORY_SEPARATOR.$fileStored->getFilename();
        $finalPath = $path.DIRECTORY_SEPARATOR.$fileStored->getFilename();

        if (Storage::disk($this->disk)->exists($finalPath))
            throw new Exception('Ya existe un archivo con ese nombre');

        if (Storage::disk($this->disk)->move($tempPath, $finalPath) == false)
            return null;

        return new File(Storage::disk($this->disk)->path($finalPath));
    }

    /**
     * @param UploadedFile $file
     * @return File
     * @throws Exception
     */
    public function uploadChunkFileToTemp(UploadedFile $file): File
    {
        try {
            if (Storage::disk($this->disk)->exists('temp') === false)
                Storage::disk($this->disk)->makeDirectory('temp');

            $fullTempFile = Storage::disk($this->disk)->path('temp'.DIRECTORY_SEPARATOR.$file->getClientOriginalName());
            $out = @fopen($fullTempFile, 'ab');
            $in = @fopen($file->getPathname(), 'rb');
            while ($buff = fread($in, 4096)) {
                fwrite($out, $buff);
            }
            @fclose($out);
            @fclose($in);

            return new File($fullTempFile);
        } catch (Exception $exception) {
            throw new Exception('No se ha podido subir el archivo');
        }
    }

    /**
     * Add File to Database
     * @param File $fileStored
     * @param string $type Type of file
     * @param string $model Model of the entity to attach
     * @param int $id Id of the entity to attach
     * @return \App\Models\File
     */
    public function addUploadedFileToDatabase(File $fileStored, string $type, string $model, int $id, ?string $tag): \App\Models\File
    {
        $fileEntity = new \App\Models\File();
        $fileEntity->file_name = $fileStored->getFilename();
        $fileEntity->file_extension = $fileStored->getExtension();
        $fileEntity->file_type = $fileStored->getMimeType();
        $fileEntity->file_size = $fileStored->getSize();
        $fileEntity->order = 1000;
        $fileEntity->type = $type;
        $fileEntity->setTranslation('name', 'es', $fileStored->getFilename());
        $fileEntity->setTranslation('description', 'es', '');
        $fileEntity->attachable_type = 'App\\Models\\'.$model;
        $fileEntity->attachable_id = $id;
        $fileEntity->enc = false;
        $fileEntity->hash = null;

        if ($tag != '')
            $fileEntity->tag = $tag;

        if (!$fileEntity->exists)
        {
            $fileEntity->created_by = Auth::user()->id;
        }
        $fileEntity->updated_by = Auth::user()->id;

        $fileEntity->save();

        return $fileEntity;
    }

    /**
     * Get physical path to a file
     * @param \App\Models\File $file
     * @return string
     */
    public function getPhysicalPath(\App\Models\File $file): string
    {
        $array = explode('\\', $file->attachable_type);
        $model = strtolower(end($array));
        return Storage::disk($this->disk)->path($model.DIRECTORY_SEPARATOR.$file->attachable_id.DIRECTORY_SEPARATOR.$file->file_name);
    }

    public function fileExists(\App\Models\File $file): bool {
        $array = explode('\\', $file->attachable_type);
        $model = strtolower(end($array));

        return Storage::disk($this->disk)->exists($model.DIRECTORY_SEPARATOR.$file->attachable_id.DIRECTORY_SEPARATOR.$file->file_name);
    }

    /**
     * Delete file from HD
     * @param \App\Models\File $file
     * @return bool
     */
    public function deleteFile(\App\Models\File $file): bool
    {
        $array = explode('\\', $file->attachable_type);
        $model = strtolower(end($array));
        return Storage::disk($this->disk)->delete($model.DIRECTORY_SEPARATOR.$file->attachable_id.DIRECTORY_SEPARATOR.$file->file_name);
    }
}
