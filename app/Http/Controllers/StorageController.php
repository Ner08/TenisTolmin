<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function show($filename)
    {
        $base = realpath(storage_path('app/public'));
        $path = realpath(storage_path('app/public/' . $filename));

        if (!$path || !str_starts_with($path, $base . DIRECTORY_SEPARATOR)) {
            abort(404);
        }

        return response()->file($path);
    }
}
