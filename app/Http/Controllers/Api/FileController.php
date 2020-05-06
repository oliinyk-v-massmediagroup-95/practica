<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\FileCreateRequest;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\Request;


class FileController extends Controller
{
    private $service;

    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    public function set(FileCreateRequest $request)
    {
        $fileModel = $this->service->userCreateFile(
            $request->user(),
            $request->file('file'),
            $request->input('delete_date'),
            $request->input('comment')
        );

        return response()->json(['id' => $fileModel->id]);
    }

    public function get(Request $request, $id)
    {
        $file = File::findUserFile($request->user(), $id)->first();

        if (!isset($file)) {
            return response(['message' => 'File not found'], 404);
        }

        return response()->file($file->getFilePath());
    }

    public function delete(Request $request, $id)
    {
        $user = $request->user();
        $file = File::findUserFile($user, $id)->first();

        if (!isset($file)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        $this->service->userDeleteFile($user, $file);

        return response()->json(['message' => 'File with ID:' . $id . ' deleted']);
    }
}
