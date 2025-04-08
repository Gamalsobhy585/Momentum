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
            'user_id' => 'required|exists:users,id',

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
            'user_id.required' => __('messages.validation.user_id_required'),
            'user_id.exists' => __('messages.validation.user_id_exists'),
        ];
    }
    
}