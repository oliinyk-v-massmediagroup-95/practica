<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\File;
use Illuminate\Http\Request;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Response;
use App\Http\Requests\Api\User\FileCreateRequest;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{
    private $service;

    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    /**
     * @param FileCreateRequest $request
     *
     * @return JsonResponse
     */
    public function set(FileCreateRequest $request): JsonResponse
    {
        $fileModel = $this->service->userCreateFile(
            $request->user(),
            $request->file('file'),
            $request->get('delete_date'),
            $request->get('comment')
        );

        return response()->json(['id' => $fileModel->id]);
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse|BinaryFileResponse
     */
    public function get(Request $request, int $id)
    {
        $user = $request->user();
        $file = File::query()->byUserId($user->id)->find($id);

        if (!isset($file)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        return response()->file($file->getFilePath());
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function delete(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $file = File::query()->byUserId($user->id)->find($id);

        if (!isset($file)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        $this->service->userDeleteFile($user, $file);

        return response()->json(['message' => 'File with ID:' . $id . ' deleted']);
    }
}
