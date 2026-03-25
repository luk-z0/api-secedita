<?php

namespace App\Http\Requests\Post;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'        => 'required|string|max:255',
            'summary'      => 'required|string',
            'content'      => 'required|string',
            'category'     => 'required|string',
            'sub_category' => 'nullable|string',
            'department'   => 'nullable|string',
            'status'       => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'file'         => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240', // Max 10MB
        ];
    }
}
