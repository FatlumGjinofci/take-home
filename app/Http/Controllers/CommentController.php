<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = Comment::get();


        $res = $comments->paginate(10);

        if ($request->has('limit')) {
            $res =$comments->paginate($request->limit);
        }

        return response()->json([
            'result' => $res,
            'count' => $comments->count(),
        ]);
    }

    public function store(CommentRequest $request)
    {
        return new CommentResource(Comment::create($request->validated()));
    }

    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());

        return new CommentResource($comment);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json();
    }
}
