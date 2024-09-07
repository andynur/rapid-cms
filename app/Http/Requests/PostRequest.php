<?php

namespace App\Http\Requests;

use App\Data\PostData;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title'           => 'required|string|max:255',
            'slug'            => 'nullable|string|unique:posts,slug,' . ($this->post->id ?? 0),
            'main_image'      => 'nullable|string',
            'categories'      => 'nullable|string',
            'published_at'    => 'nullable|date',
            'body'            => 'required|string',
        ];
    }

    public function toData(): PostData
    {
        return PostData::from($this->validated());
    }
}
