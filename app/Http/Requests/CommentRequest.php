<?php

namespace App\Http\Requests;

use App\Data\CommentData;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string|max:1000',
        ];
    }

    public function toData(): CommentData
    {
        return CommentData::from($this->validated());
    }

    public function messages()
    {
        return [
            'name.required' => 'Your name is required.',
            'email.required' => 'A valid email address is required.',
            'comment.required' => 'A comment is required.',
        ];
    }
}
