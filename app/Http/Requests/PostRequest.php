<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules()
    {
        return [
            'topic' => ['required'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
