<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function scopeFilter($query, $request)
    {
        return $query
            ->when($request->filled('id'), function ($query) use ($request) {
                return $query->where('id', $request->id);
            })
            ->when($request->filled('post_id'), function ($query) use ($request) {
                return $query->where('post_id', $request->post_id);
            })
            ->when($request->filled('content'), function ($query) use ($request) {
                return $query->where('content', 'like', '%'.$request->content.'%');
            })
            ->when($request->filled('abbreviation'), function ($query) use ($request) {
                return $query->where('abbreviation', 'like', '%'.$request->abbreviation);
            })
            ->when($request->filled('created_at'), function ($query) use ($request) {
                return $query->whereDate('created_at', $request->created_at);
            })
            ->when($request->filled('updated_at'), function ($query) use ($request) {
                return $query->whereDate('updated_at', $request->updated_at);
            })
            ->when($request->filled('sort') && $request->filled('direction'), function ($query) use ($request) {
                return $query->orderBy($request->sort, $request->direction);
            })
            ->when($request->filled('sort'), function ($query) use ($request) {
                return $query->orderByDesc($request->sort);
            })
            ->when($request->filled('with'), function ($query) {
                return $query->with('post');
            });
    }
}
