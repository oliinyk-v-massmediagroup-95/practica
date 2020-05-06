<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Http\Request;

class AccessFileController extends Controller
{
    public function file(Request $request)
    {
        if (\Auth::check()) {
            $file = File::where('user_id', \Auth::id())->where('name', $request->file_name)->first();

            if (isset($file)) {
                return response()->file($file->getFilePath());
            }
        }

        abort(404);
    }

    public function token(Request $request, LinkService $service)
    {
        $token = $request->token;
        $link = Link::with('file')->where('token', $token)->first();

        if (!isset($link)) {
            abort(404);
        }

        if (\Auth::check()) {
            if (\Auth::id() === $link->user_id) {
                return response()->file($link->file->getFilePath());
            }
        }

        if ($link->isOneTimeLink()) {
            if ($link->hasBeenVisited()) {
                abort(404);
            }
        }

        $service->incrementLinkCounter($link);
        return response()->file($link->file->getFilePath());
    }
}
