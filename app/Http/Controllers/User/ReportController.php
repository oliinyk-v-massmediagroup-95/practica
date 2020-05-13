<?php
declare(strict_types=1);

namespace App\Http\Controllers\User;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\ReportService;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * @param Request $request
     * @param ReportService $service
     *
     * @return View
     */
    public function index(Request $request, ReportService $service): View
    {
        $user = \Auth::user();

        return view('user.pages.report.index', [
            'countLinksViews' => $service->countLinksViewsByUser($user),
            'countVisitedTemporaryLinks' => $service->countVisitedTemporaryLinksByUser($user),
            'countTemporaryLinks' => $service->countTemporaryLinksByUser($user),
            'countTrashedFiles' => $service->countTrashedFilesByUser($user),
            'countExistingFiles' => $service->countExistingFilesByUser($user),
        ]);
    }
}
