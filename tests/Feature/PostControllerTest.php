<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test__return_paginated_posts_with_default_limit()
    {
        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'result' => [
                    'data',
                    'links',
                ],
                'count',
            ]);
    }

    public function test_return_paginated_posts_with_custom_limit()
    {
        $response = $this->getJson('/api/posts?limit=5');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'result' => [
                    'data',
                    'links',
                ],
                'count',
            ]);
    }

    public function testDeletePost()
    {
        $post = Post::factory(1)->create()->first();

        $response = $this->delete('/api/posts/'.$post->id);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Post deleted successfully',
            ]);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
