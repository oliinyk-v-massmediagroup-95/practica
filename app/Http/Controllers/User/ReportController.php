<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request, ReportService $service)
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
