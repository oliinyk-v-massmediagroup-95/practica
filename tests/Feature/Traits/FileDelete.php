<?php

namespace Tests\Feature\Traits;

use App\Models\File;

trait FileDelete
{
    private function assertFileExistAndDelete(File $file)
    {
        $this->assertTrue(file_exists($file->getFilePath()));

        if (file_exists($file->getFilePath())) {
            \Storage::disk('public')->delete($file->getUrlPath());
        }
    }
}