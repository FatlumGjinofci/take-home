<?php

namespace Tests\Feature;

use App\Http\Controllers\CommentController;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function testReturnCommentsWithPagination()
    {
        Comment::factory()->count(15)->create();

        $response = $this->getJson('/api/comments');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'result' => [
                    'links' => [
                        'first',
                        'last',
                        'prev',
                        'next',
                    ],
                    'meta' => [
                        'current_page',
                        'from',
                        'links',
                        'path',
                        'to',
                        'total',
                    ],
                    'data' => [],
                ],
                'count',
            ]);
    }

    /** @test */
    public function testReturnCommentsWithLimit()
    {
        Comment::factory()->count(5)->create();

        $response = $this->getJson('/api/comments?limit=2');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'result' => [
                    'links' => [
                        'first',
                        'last',
                        'prev',
                        'next',
                    ],
                    'meta' => [
                        'current_page',
                        'from',
                        'links',
                        'path',
                        'to',
                        'total',
                    ],
                    'data' => [],
                ],
                'count',
            ]);
    }

    /** @test */
    public function testStoreComment()
    {
        $commentServiceMock = Mockery::mock(CommentService::class);

        $requestData = [
            'comment' => 'This is a test comment',
        ];
        $commentServiceMock->shouldReceive('create')
            ->once()
            ->with(Mockery::type(CommentRequest::class))
            ->andReturn($requestData);

        $controller = new CommentController($commentServiceMock);

        $request = Mockery::mock(CommentRequest::class);
        $response = $controller->store($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertTrue($data['status']);
        $this->assertEquals('Comment created successfully', $data['message']);
        $this->assertEquals($requestData, $data['comment']);
    }

    public function testStoreCommentExists()
    {
        $commentServiceMock = Mockery::mock(CommentService::class);

        $commentServiceMock->shouldReceive('create')
            ->once()
            ->with(Mockery::type(CommentRequest::class))
            ->andReturn(null);

        $controller = new CommentController($commentServiceMock);

        $request = Mockery::mock(CommentRequest::class);
        $response = $controller->store($request);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertFalse($data['status']);
        $this->assertEquals('Comment with this abbreviation already exists', $data['message']);
        $this->assertArrayNotHasKey('comment', $data);
    }

    public function testDeleteComment()
    {
        $comment = Comment::factory()->create();

        $response = $this->deleteJson('/api/comments/'.$comment->id);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Comment deleted successfully',
            ]);

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
