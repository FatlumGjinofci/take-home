<?php

namespace App\Services;

use App\Helpers\CommentHelper;
use App\Models\Comment;
use App\Models\Post;

class CommentService
{

    public function create($request)
    {
        $abbreviation = CommentHelper::abbreviation($request->content);

        if (Comment::where('abbreviation', $abbreviation)->first()) {
            return false;
        }

        return Comment::create([
            'post_id' => Post::inRandomOrder()->first()->id,
            'content' => $request->content,
            'abbreviation' => $abbreviation,
        ]);
    }
}
