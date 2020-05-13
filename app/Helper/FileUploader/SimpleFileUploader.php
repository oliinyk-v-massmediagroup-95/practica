<?php
declare(strict_types=1);

namespace App\Helper\FileUploader;

use Illuminate\Http\UploadedFile;

class SimpleFileUploader implements FileUploaderInterface
{
    private string $defaultFolder = 'uploads';

    public function upload(UploadedFile $file, string $folder = ''): string
    {
        $storeFolder = strlen($folder) ? '/' . $folder : '';

        return $file->store($this->defaultFolder . $storeFolder, 'public');
    }
}
