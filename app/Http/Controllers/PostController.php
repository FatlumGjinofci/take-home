<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::filter($request);

        $res = $request->filled('limit')
            ? $posts->paginate($request->limit)->withQueryString()
            : $posts->paginate(10)->withQueryString();

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
