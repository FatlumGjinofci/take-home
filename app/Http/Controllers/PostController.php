<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query();

        $res = $posts->paginate(10);

        if ($request->has('id')) {
            $res = $posts->where('id', $request->id);
        }

        if ($request->has('topic')) {
            $res = $posts->where('topic', 'like', '%'.$request->topic.'%');
        }

        if ($request->has('created_at')) {
            $res = $posts->whereDate('created_at', $request->created_at);
        }

        if ($request->has('updated_at')) {
            $res = $posts->whereDate('updated_at', $res->updated_at);
        }

        if ($request->has('sort') && $request->has('direction')) {
            $res = $posts->orderBy($request->sort, $request->direction);
        }

        if ($request->has('sort')) {
            $res = $posts->orderByDesc($request->sort);
        }

        if ($request->has('with')) {
            $res = $posts->with('comments');
        }

        if ($request->has('comment')) {
            $res = $posts->with(['comments' => function ($item) use ($request) {
                $item->where('content', 'like', '%'.$request->comment.'%');
            }])->count();
        }

        $res = $posts->paginate($request->limit ?? 10)->withQueryString();

        return response()->json([
            'result' => $res,
            'count' => $res->count(),
        ]);

    }

    public function delete(Post $post)
    {
        $post->delete();

        return response()->json([
            'status' => true,
            'message' => 'Post deleted successfully',
        ]);
    }
}
