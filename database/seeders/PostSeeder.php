<?php

namespace Database\Seeders;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        if (Post::count() > 1) {
            Post::truncate();
        }

        $posts = [
            [
                'topic' => 'Artificial Intelligence and Automation',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'topic' => 'Climate Change and Sustainability',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'topic' => 'Biotechnology and Genetic Engineering',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'topic' => 'Cyber-security and Privacy',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'topic' => 'Space Exploration',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        Post::insert($posts);
    }
}
