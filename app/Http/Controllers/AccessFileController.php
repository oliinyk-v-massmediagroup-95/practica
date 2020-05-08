<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Link;
use Illuminate\Http\Request;
use App\Services\LinkService;

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
        $link = Link::with('file')->where('token', $request->token)->first();

        if (! isset($link) || ! is_file($link->file->getFilePath())) {
            abort(404);
        }

        if (\Auth::check() && \Auth::id() === $link->user_id) {
            return response()->file($link->file->getFilePath());
        }

        if ($link->isOneTimeLink() && $link->hasBeenVisited()) {
            abort(404);
        }

        $service->incrementLinkCounter($link);
        return response()->file($link->file->getFilePath());
    }
}
