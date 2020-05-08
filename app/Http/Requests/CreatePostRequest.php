<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniquePostTitle;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required','string','max:255', new UniquePostTitle],
            'content' => ['required'],
            'tags' => ['nullable','max:10'],
            'images' => ['nullable', 'max:10',]
        ];
    }
}
