<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\LinkCreateRequest;
use App\Models\File;
use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function create(LinkCreateRequest $request, LinkService $service)
    {
        $user = $request->user();
        $file_id = $request->input('file_id');
        $only_once = $request->input('only_once');

        $file = File::findUserFile($user, $file_id)->firstOr(function () {
            abort(404);
        });

        $link = $service->generateLink([
            'user_id' => $user->id,
            'file_id' => $file->id,
            'only_once' => $only_once,
        ]);

        return response()->json($link->getGeneratedLink());
    }
}
