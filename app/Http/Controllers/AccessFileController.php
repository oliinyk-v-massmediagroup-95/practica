<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Link;
use Illuminate\Http\Request;
use App\Services\LinkService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AccessFileController extends Controller
{
    /**
     * @param Request $request
     *
     * @return BinaryFileResponse
     */
    public function file(Request $request): ?BinaryFileResponse
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            $file = File::query()->byUserId($user->id)->where('name', $request->file_name)->first();

            if (isset($file)) {
                return response()->file($file->getFilePath());
            }
        }

        abort(404);
    }

    /**
     * @param Request $request
     * @param LinkService $service
     *
     * @return BinaryFileResponse
     */
    public function token(Request $request, LinkService $service): BinaryFileResponse
    {
        $link = Link::with('file')->where('token', $request->token)->first();

        if (!isset($link) && !is_file($link->file->getFilePath())) {
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
