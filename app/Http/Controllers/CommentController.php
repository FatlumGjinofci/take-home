<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
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
        $comments = Comment::query();

        if ($request->has('id')) {
            $res = $comments->where('id', $request->id);
        }
        if ($request->has('post_id')) {
            $res = $comments->where('post_id', $request->post_id);
        }
        if ($request->has('content')) {
            $res = $comments->where('content', 'like', '%'.$request->content.'%');
        }
        if ($request->has('abbreviation')) {
            $res = $comments->where('abbreviation', 'like', '%'.$request->abbreviation);
        }
        if ($request->has('created_at')) {
            $res = $comments->whereDate('created_at', $request->created_at);
        }
        if ($request->has('updated_at')) {
            $res = $comments->whereDate('updated_at', $res->updated_at);
        }

        if ($request->has('sort') && $request->has('direction')) {
            $res = $comments->orderBy($request->sort, $request->direction);
        }

        if ($request->has('sort')) {
            $res = $comments->orderByDesc($request->sort);
        }

        if ($request->has('with')) {
            $res = $comments->with('post');
        }

        if ($request->has('limit')) {
            $res = $comments->paginate($request->limit)->withQueryString();
        }

        $res = $comments->paginate(10)->withQueryString();

        return response()->json([
            'result' => $res,
            'count' => $comments->count(),
        ]);
    }

    public function store(CommentRequest $request)
    {
        try {
            $comment = $this->commentService->create($request);

            if (! $comment) {
                return response()->json([
                    'status' => false,
                    'message' => 'Abbreviation for comment exists already!',
                ]);
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
