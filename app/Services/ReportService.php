<?php

namespace App\Services;

use App\User;
use App\Models\File;
use App\Models\Link;

class ReportService
{
    public function countLinksViewsByUser(User $user): int
    {
        return Link::byUser($user)->sum('entry_counter');
    }

    public function countVisitedTemporaryLinksByUser(User $user): int
    {
        return Link::byUser($user)->onlyTemporary()->visited()->count();
    }

    public function countTemporaryLinksByUser(User $user): int
    {
        return Link::byUser($user)->onlyTemporary()->count();
    }

    public function countTrashedFilesByUser(User $user): int
    {
        return File::byUser($user)->onlyTrashed()->count();
    }

    public function countExistingFilesByUser(User $user): int
    {
        return File::byUser($user)->count();
    }
}
