<?php
declare(strict_types=1);

namespace Tests\Feature\Traits;

use App\Models\File;

trait FileDelete
{
    private function assertFileExistAndDelete(File $file)
    {
        if (file_exists($file->getFilePath())) {
            \Storage::disk('public')->delete($file->getUrlPath());
            \Storage::disk('public')->assertMissing($file->getUrlPath());

            $directories = \Storage::disk('public')->allDirectories('uploads');

            foreach ($directories as $directory) {
                $path = \Storage::disk('public')->path($directory);

                if ($this->isDirEmpty($path)) {
                    rmdir($path);
                }
            }
        }
    }

    private function isDirEmpty($dir)
    {
        if (!is_readable($dir)) {
            return null;
        }

        return (count(scandir($dir)) === 2);
    }
}
