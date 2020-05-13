<?php
declare(strict_types=1);

namespace App\Transformers;

use App\Models\Link;
use League\Fractal\TransformerAbstract;

class LinkTransformer extends TransformerAbstract
{
    public function transform(Link $link): array
    {
        return [
            'accessLink' => $this->getAccessLink($link),
            'isVisited' => $link->hasBeenVisited(),
        ];
    }

    private function getAccessLink(Link $link): string
    {
        return route('token.link', ['token' => $link->token]);
    }
}
