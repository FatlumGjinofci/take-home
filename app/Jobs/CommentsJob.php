<?php

namespace App\Jobs;

use App\Helpers\CommentHelper;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CommentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle()
    {
        $dataset = collect(config('data.dataset '));

        $dataset->each(function ($item) {
            $abbreviation = CommentHelper::abbreviation($item);

            Comment::create([
                'post_id' => Post::inRandomOrder()->first()->id,
                'content' => $item,
                'abbreviation' => $abbreviation,
            ]);
        });
    }
}
