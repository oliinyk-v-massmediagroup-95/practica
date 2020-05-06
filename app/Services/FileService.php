<?php

namespace App\Services;

use App\Helper\FileUploader\FileUploaderInterface;
use App\Models\Comment;
use App\Models\File;
use App\User;
use Illuminate\Http\UploadedFile;

class FileService
{
    private FileUploaderInterface $uploader;

    public function __construct(FileUploaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }

    public function userCreateFile(
        User $user,
        UploadedFile $file,
        ?string $deleteDate,
        ?string $commentText
    ): File {
        $urlPath = $this->uploader->upload($file, $user->id);

        $fileModel = File::create([
            'ext' => $file->clientExtension(),
            'type' => 'image',
            'path' => $urlPath,
            'original_name' => $file->getClientOriginalName(),
            'name' => $file->hashName(),
            'user_id' => $user->id,
            'delete_date' => isset($deleteDate) ? new \DateTime($deleteDate) : $deleteDate,
        ]);

        if (isset($commentText)) {
            $commentModel = Comment::create(['text' => $commentText, 'user_id' => $user->id]);
            $fileModel->comments()->attach($commentModel->id);
        }

        return $fileModel;
    }

    public function userUpdateFile(
        File $fileModel,
        User $user,
        ?UploadedFile $file,
        ?string $deleteDate,
        ?string $commentText
    ): File {

        if (isset($file)) {
            $oldFilePath = $fileModel->getFilePath();
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $urlPath = $this->uploader->upload($file, $user->id);

            $newData['ext'] = $file->clientExtension();
            $newData['path'] = $urlPath;
            $newData['original_name'] = $file->getClientOriginalName();
            $newData['name'] = $file->hashName();
        }

        $newData['delete_date'] = isset($deleteDate) ? new \DateTime($deleteDate) : $deleteDate;

        $fileModel->update($newData);
        $commentModel = $fileModel->getCreatorComment();

        if (isset($commentModel)) {
            $commentModel->update(['text' => $commentText]);
        } elseif (isset($commentText) && !isset($commentModel)) {
            Comment::create(['text' => $commentText, 'user_id' => $user->id]);
        }

        return $fileModel;
    }

    public function userDeleteFile(User $user, File $file): void
    {
        if ($user->id === $file->user_id) {
            if (file_exists($file->getFilePath())) {
                unlink($file->getFilePath()) ;
            }

            $file->delete();
            $file->comments()->delete();
            $file->comments()->detach();
            $file->links()->delete();
        }
    }
}
