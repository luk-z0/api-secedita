<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PaginationRequest extends FormRequest
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
            'perPage' => 'nullable|integer|max:100',
            'page'    => 'nullable|integer',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'page' => $this->query(
                'current_page',
                 config('pagination.defaults.current_page'
            )),
            'perPage' => $this->query(
                'perPage',
                config('pagination.defaults.per_page'
            )),
        ]);
    }

    public function messages(): array
    {
        return [
            'current_page.integer' => 'The current page must be a number.',
            'per_page.integer'     => 'The per page limit must be a number.',
        ];
    }
}
