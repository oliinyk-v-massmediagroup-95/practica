<?php

namespace App\Http\Controllers\Api;

use App\Models\File;
use App\Services\LinkService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\LinkCreateRequest;

class LinkController extends Controller
{
    public function create(LinkCreateRequest $request, LinkService $service)
    {
        $user = $request->user();
        $file_id = $request->input('file_id');
        $only_once = $request->input('only_once');

        $file = File::findUserFile($user, $file_id)->first();

        if (! isset($file)) {
            return response(['message' => 'File not found'], 404);
        }

        $link = $service->generateLink([
            'user_id' => $user->id,
            'file_id' => $file->id,
            'only_once' => $only_once,
        ]);

        return response()->json($link->getGeneratedLink());
    }
}
