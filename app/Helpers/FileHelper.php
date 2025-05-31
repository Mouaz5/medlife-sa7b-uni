<?php

namespace App\Helpers;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function upload($file, string $path)
    {
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($path, $fileName, 'public');
        return 'storage/' . $path;
    }

    public static function delete(string $path)
    {
        $relativePath = str_replace('storage/', '', $path);
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);}
    }

    public static function replace(UploadedFile $file, string $oldPath, $newPath)
    {
        if (!empty($oldPath)) {
        self::delete($oldPath);
        }
        return self::upload($file, $newPath);
    }

}
