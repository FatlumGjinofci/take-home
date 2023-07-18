<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'post_id' => ['required', 'integer'],
            'content' => ['required'],
            'abbervation' => ['required'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
