<?php

namespace App\Helper\FileUploader;

use Illuminate\Http\UploadedFile;

interface FileUploaderInterface
{
    public function upload(UploadedFile $file, string $folder = ''): string;
}
