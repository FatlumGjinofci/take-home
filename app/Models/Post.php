<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeFilter($query, $request)
    {
        return $query
            ->when($request->filled('id'), function ($query) use ($request) {
                return $query->where('id', $request->id);
            })
            ->when($request->filled('topic'), function ($query) use ($request) {
                return $query->where('topic', 'like', '%'.$request->topic.'%');
            })
            ->when($request->filled('created_at'), function ($query) use ($request) {
                return $query->whereDate('created_at', $request->created_at);
            })
            ->when($request->filled('updated_at'), function ($query) use ($request) {
                return $query->whereDate('updated_at', $request->updatedAt);
            })
            ->when($request->filled('sort') && $request->filled('direction'), function ($query) use ($request) {
                return $query->orderBy($request->sort, $request->direction);
            })
            ->when($request->filled('sort'), function ($query) use ($request) {
                return $query->orderByDesc($request->sort);
            })
            ->when($request->filled('with'), function ($query) {
                return $query->with('comments');
            })
            ->when($request->filled('comment'), function ($query) use ($request) {
                return $query->with(['comments' => function ($item) use ($request) {
                    return $item->where('content', 'like', '%'.$request->comment.'%');
                }]);
            });
    }
}
