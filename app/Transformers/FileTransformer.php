<?php
declare(strict_types=1);

namespace App\Transformers;

use App\Models\File;
use League\Fractal\TransformerAbstract;

class FileTransformer extends TransformerAbstract
{
    public function transform(File $file): array
    {
        return [
            'id' => (int)$file->id,
            'original_name' => (string)$file->original_name,
            'url_path' => $file->getUrlPath(),
            'update_path' => route('user.file.edit', ['file' => $file]),
            'delete_path' => route('user.file.destroy', ['file' => $file]),
            'show_path' => route('user.file.show', ['file' => $file])
        ];
    }

}
