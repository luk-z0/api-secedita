<?php
namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:services,name,' . $this->route('service'),
            ],
            'sector' => 'required|string|max:150',
            'description' => 'nullable|string|max:2000',
            'is_active' => 'boolean',
            'availability' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do serviço é obrigatório.',
            'name.unique' => 'Já existe um serviço cadastrado com este nome.',
            'sector.required' => 'Informe qual setor é responsável por este serviço.',
            'description.max' => 'A descrição não pode ultrapassar 2000 caracteres.',
        ];
    }
}
