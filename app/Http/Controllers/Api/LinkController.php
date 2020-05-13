<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\File;
use App\Services\LinkService;
use App\Transformers\LinkTransformer;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\LinkCreateRequest;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class LinkController extends Controller
{
    /**
     * @param LinkCreateRequest $request
     * @param LinkService $service
     * @param Manager $fractal
     * @param LinkTransformer $linkTransformer
     *
     * @return JsonResponse
     */
    public function create(
        LinkCreateRequest $request,
        LinkService $service,
        Manager $fractal,
        LinkTransformer $linkTransformer
    ): JsonResponse {
        $user = $request->user();
        $fileId = $request->get('file_id');
        $onlyOnce = $request->get('only_once');

        $file = File::query()->byUserId($user->id)->find($fileId);

        if (!isset($file)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        $link = $service->createLink($user, $file, (int) $onlyOnce);
        $resultData = $fractal->createData(new Item($link, $linkTransformer));

        return response()->json($resultData->toArray());
    }
}
