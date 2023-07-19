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
        $comments = Comment::query();


        $res = $comments->paginate(10);

        if ($request->has('id')) {
            $res = $comments->where('id', $request->id);
        }
        if ($request->has('post_id')) {
            $res = $comments->where('post_id', $request->post_id);
        }
        if ($request->has('content')) {
            $res = $comments->where('content', 'like', "%".$request->content."%");
        }
        if ($request->has('abbreviation')) {
            $res = $comments->where('abbreviation', 'like', "%".$request->abbreviation);
        }
        if($request->has('created_at')) {
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

        $res = $comments->paginate($request->limit ?? 10);

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
