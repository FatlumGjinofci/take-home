<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(
        public CommentService $commentService
    ) {
    }

    public function index(Request $request)
    {
        $comments = Comment::filter($request);

        $res = $request->filled('limit')
            ? $comments->paginate($request->limit)->withQueryString()
            : $comments->paginate(10)->withQueryString();

        return response()->json([
            'result' => CommentResource::collection($res)->response()->getData(true),
            'count' => $res->count(),
        ]);
    }

    public function store(CommentRequest $request)
    {
        try {
            $comment = $this->commentService->create($request);

            if (! $comment) {
                return response()->json([
                    'status' => false,
                    'message' => 'Comment with this abbreviation already exists',
                ], 400);
            }

            return response()->json([
                'status' => true,
                'message' => 'Comment created successfully',
                'comment' => $comment,
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $exception->getMessage(),
            ], 400);
        }
    }

    public function delete(Comment $comment)
    {
        $comment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Comment deleted successfully',
        ]);
    }
}
