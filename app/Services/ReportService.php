<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\File;
use App\Models\Link;
use App\Models\User;

class ReportService
{
    public function countLinksViewsByUser(User $user): int
    {
        return Link::byUserId($user->id)->sum('entry_counter');
    }

    public function countVisitedTemporaryLinksByUser(User $user): int
    {
        return Link::byUserId($user->id)->onlyTemporary()->visited()->count();
    }

    public function countTemporaryLinksByUser(User $user): int
    {
        return Link::byUserId($user->id)->onlyTemporary()->count();
    }

    public function countTrashedFilesByUser(User $user): int
    {
        return File::byUserId($user->id)->onlyTrashed()->count();
    }

    public function countExistingFilesByUser(User $user): int
    {
        return File::byUserId($user->id)->count();
    }
}
