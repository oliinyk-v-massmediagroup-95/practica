<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileCreateReqeust;
use App\Http\Requests\FileUpdateRequest;

use App\Models\File;
use App\Models\Link;
use App\Services\FileService;

class FileController extends Controller
{
    private $service;

    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('user.pages.file.index', [
            'files' => File::byUser(\Auth::user())->orderBy('id', 'desc')->get()
        ]);
    }

    public function create()
    {
        return view('user.pages.file.create', []);
    }

    public function store(FileCreateReqeust $request)
    {
        $this->service->userCreateFile(
            \Auth::user(),
            $request->file('file'),
            $request->input('delete_date'),
            $request->input('comment')
        );

        return redirect(route('user.file.index'));
    }

    public function show($id)
    {
        $user = \Auth::user();
        $file = File::findUserFile($user, $id)
            ->with(['comments', 'multi_time_links', 'one_time_links'])
            ->firstOr(function () {
                abort(404);
            });

        return view('user.pages.file.show', [
            'file' => $file,
            'user' => $user,
            'multiTimeLinks' => $file->multi_time_links ?? [],
            'oneTimeLinks' => $file->one_time_links ?? [],
            'ONE_TIME_LINK' => Link::ONE_TIME_LINK,
            'MULTI_TIME_LINK' => Link::MULTI_TIME_LINK,
        ]);
    }

    public function edit($id)
    {
        $file = File::findUserFile(\Auth::user(), $id)
            ->with('comments')->firstOr(function () {
                abort(404);
            });

        return view('user.pages.file.edit', [
            'file' => $file,
            'comment' => $file->getCreatorComment()
        ]);
    }

    public function update(FileUpdateRequest $request, $id)
    {
        $user = \Auth::user();
        $file = File::findUserFile($user, $id)->firstOr(function () {
            abort(404);
        });

        $this->service->userUpdateFile(
            $file,
            $user,
            $request->file('file'),
            $request->input('delete_date'),
            $request->input('comment')
        );

        return redirect(route('user.file.index'));
    }

    public function destroy($id)
    {
        $user = \Auth::user();
        $file = File::findUserFile($user, $id)->firstOr(function () {
            abort(404);
        });

        $this->service->userDeleteFile($user, $file);

        return redirect(route('user.file.index'));
    }
}
