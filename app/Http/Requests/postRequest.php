<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class postRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'        =>  'required|string|max:255',
            'content'      =>  'required|string',
            'category_id'  =>  'required|exists:categories,id',
            // 'user_id'  =>  'required|exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'title.string'   => 'Title must be a string',
            'title.max'      => 'Title must be less than 255 characters',
            'content.required' => 'Content is required',
            'content.string'   => 'Content must be a string',
        ];
    }
}
