<?php

namespace App\Http\Controllers;

use App\Data\PostData;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::filter($request);

        $res = $request->filled('limit')
            ? $posts->fastPaginate($request->limit)->withQueryString()
            : $posts->fastPaginate(10)->withQueryString();

        return response()->json([
            'result' => PostData::collection($res),
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
