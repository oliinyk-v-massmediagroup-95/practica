<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\File;
use App\Models\Link;
use App\Models\User;

class LinkService
{
    public const TOKEN_LENGTH = 55;

    public function createLink(User $user, File $file, int $only_once): Link
    {
        if ($only_once === Link::ONE_TIME_LINK) {
            return $this->createOneTimeLink($user, $file);
        }

        return $this->createMultiTimeLink($user, $file);
    }

    public function createOneTimeLink(User $user, File $file): Link
    {
        $data['token'] = $this->generateToken();
        $data['only_once'] = Link::ONE_TIME_LINK;
        $data['user_id'] = $user->id;
        $data['file_id'] = $file->id;

        return Link::create($data);
    }

    public function createMultiTimeLink(User $user, File $file): Link
    {
        $data['token'] = $this->generateToken();
        $data['only_once'] = Link::MULTI_TIME_LINK;
        $data['user_id'] = $user->id;
        $data['file_id'] = $file->id;

        return Link::create($data);
    }

    public function incrementLinkCounter(Link $link): void
    {
        if (session()->get(url()->current()) === null) {
            session()->push(url()->current(), 1);
            $link->entry_counter++;
            $link->save();
        }
    }

    public function generateToken()
    {
        return \Str::random(self::TOKEN_LENGTH);
    }
}
