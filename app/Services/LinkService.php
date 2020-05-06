<?php

namespace App\Services;

use App\Models\Link;

class LinkService
{
    public const TOKEN_LENGTH = 55;

    public function generateLink(array $data): Link
    {
        $data['token'] = \Str::random(self::TOKEN_LENGTH);

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
}
