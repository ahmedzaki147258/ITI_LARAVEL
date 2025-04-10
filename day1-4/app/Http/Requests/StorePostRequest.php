<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title' => ['required', 'min:3', 'unique:posts,title'],
            'description' => ['required', 'min:10'],
            'userId' => ['required', 'exists:users,id'],
            'image' => ['required', 'image', 'mimes:jpg,png'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'my custom message',
            'title.min' => 'override minimum error message for title',
            'title.unique' => 'This title already exists.',
            'description.required' => 'Description is required.',
            'description.min' => 'Description must be at least 10 characters.',
            'userId.exists' => 'Invalid user ID.',
        ];
    }
}
