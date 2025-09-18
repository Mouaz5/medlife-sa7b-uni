<?php

namespace App\Services;

use Illuminate\Http\Request;

class UploadService
{
    public function uploadFile(Request $request, string $fieldName = 'image', string $directory = 'images'): ?string
    {
        if ($request->hasFile($fieldName) && $request->file($fieldName)->isValid()) {
            $path = $request->file($fieldName)->store($directory, 'public');
            return $path; // Return just the relative path, not the full URL
        }
        return null;
    }
}
