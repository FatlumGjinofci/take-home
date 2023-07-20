<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'content' => ['required'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
