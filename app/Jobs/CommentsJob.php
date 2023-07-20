<?php

namespace App\Jobs;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

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
            $abbreviation = $this->abbreviation($item);
            Comment::create([
                'post_id' => Post::inRandomOrder()->first()->id,
                'content' => $item,
                'abbreviation' => $abbreviation,
            ]);
        });
    }

    public function abbreviation($item)
    {
        $words = explode(' ', $item);

        $abbreviation = '';
        foreach ($words as $word) {
            $abbreviation .= Str::lower(Str::substr($word, 0, 1));
        }
        return $abbreviation;
    }
}
