<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
     return true;
    }

    public function rules()
    {
        return 
        [
            'title' => 'required|string|max:255',
            'content' => 'required|string',

        ];
    }
    public function messages()
    {
        return [
            'title.required' => __('messages.validation.title_required'),
            'title.string' => __('messages.validation.title_string'),
            'title.max' => __('messages.validation.title_max'),
            'content.required' => __('messages.validation.content_required'),
            'content.string' => __('messages.validation.content_string'),
 
        ];
    }
    
}