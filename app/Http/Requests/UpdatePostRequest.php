<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return 
        [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        
        ];
    }

    public function messages()
    {
        return [
            'title.string' => __('messages.validation.title_string'),
            'title.max' => __('messages.validation.title_max'),
            'content.string' => __('messages.validation.content_string'),
        ];
    }
    
}