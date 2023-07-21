<?php

namespace Database\Seeders;

use App\Helpers\CommentHelper;
use App\Models\Comment;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        if (Comment::count() > 1) {
            Comment::truncate();
        }

        $dataset = collect(config('data.dataset '));

        $dataset->chunk(1000)->each(function ($chunk) {
            $data = [];
            foreach ($chunk as $item) {
                $abbreviation = CommentHelper::abbreviation($item);

                $data[] = [
                    'post_id' => Post::inRandomOrder()->first()->id,
                    'content' => $item,
                    'abbreviation' => $abbreviation,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            Comment::insert($data);
        });
    }
}
