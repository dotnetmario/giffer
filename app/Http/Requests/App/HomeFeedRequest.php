<?php

namespace App\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HomeFeedRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cats' => ['array','nullable', Rule::exists('categories', 'id')],
            'tags' => ['array','nullable', Rule::exists('tags', 'id')],
        ];
    }
}