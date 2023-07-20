<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class CommentHelper
{
    public static function abbreviation($item)
    {
        $words = explode(' ', $item);

        $abbreviation = '';
        foreach ($words as $word) {
            $abbreviation .= Str::lower(Str::substr($word, 0, 1));
        }
        return $abbreviation;
    }
}
