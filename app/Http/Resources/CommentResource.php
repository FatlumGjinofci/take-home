<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Comment */
class CommentResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'post_id' => $this->post_id,
            'content' => $this->content,
            'abbreviation' => $this->abbervation,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
