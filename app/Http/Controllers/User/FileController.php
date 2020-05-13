<?php
declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Models\File;
use App\Models\Link;
use App\Transformers\LinkTransformer;
use Illuminate\View\View;

use App\Services\FileService;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileCreateReqeust;
use App\Http\Requests\FileUpdateRequest;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class FileController extends Controller
{
    private $service;

    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $user = \Auth::user();

        return view('user.pages.file.index', [
            'files' => File::query()->byUserId($user->id)->orderBy('id', 'desc')->get(),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('user.pages.file.create', []);
    }

    /**
     * @param FileCreateReqeust $request
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(FileCreateReqeust $request)
    {
        $this->service->userCreateFile(
            \Auth::user(),
            $request->file('file'),
            $request->get('delete_date'),
            $request->get('comment')
        );

        return redirect(route('user.file.index'));
    }

    /**
     * @param int $id
     * @param Manager $fractal
     * @param LinkTransformer $linkTransformer
     *
     * @return View
     */
    public function show(int $id, Manager $fractal, LinkTransformer $linkTransformer): View
    {
        $user = \Auth::user();
        $file = File::query()->byUserId($user->id)
            ->with(['comments', 'multi_time_links', 'one_time_links'])
            ->findOrFail($id);

        return view('user.pages.file.show', [
            'file' => $file,
            'user' => $user,
            'multiTimeLinks' => $fractal->createData(new Collection($file->multi_time_links, $linkTransformer))->toArray(),
            'oneTimeLinks' => $fractal->createData(new Collection($file->one_time_links, $linkTransformer))->toArray(),
            'ONE_TIME_LINK' => Link::ONE_TIME_LINK,
            'MULTI_TIME_LINK' => Link::MULTI_TIME_LINK,
        ]);
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function edit($id): View
    {
        $user = \Auth::user();
        $file = File::query()->byUserId($user->id)
            ->with('comments')
            ->findOrFail($id);

        return view('user.pages.file.edit', [
            'file' => $file,
            'comment' => $file->getCreatorComment(),
        ]);
    }

    /**
     * @param FileUpdateRequest $request
     * @param int $id
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(FileUpdateRequest $request, int $id)
    {
        $user = \Auth::user();
        $file = File::query()->byUserId($user->id)->findOrFail($id);

        $this->service->userUpdateFile(
            $file,
            $user,
            $request->file('file'),
            $request->get('delete_date'),
            $request->get('comment')
        );

        return redirect(route('user.file.index'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $user = \Auth::user();
        $file = File::query()->byUserId($user->id)->findOrFail($id);

        $this->service->userDeleteFile($user, $file);

        return redirect(route('user.file.index'));
    }
}
