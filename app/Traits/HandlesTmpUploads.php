<?php

namespace App\Traits;


use Illuminate\Support\Facades\Storage;

trait HandlesTmpUploads
{
    public function clearTmpDirectory(string $directory)
    {
        if (!Storage::exists($directory)) return;

        Storage::delete(Storage::allFiles($directory));

        foreach (Storage::allDirectories($directory) as $dir) {
            Storage::deleteDirectory($dir);
        }
    }
}
