<?php
namespace App\Http\Requests\Mail;

use Illuminate\Foundation\Http\FormRequest;

class ContactMailRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|min:10|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'O nome é obrigatório.',
            'message.min'      => 'A mensagem deve ter pelo menos 10 caracteres.',
            'email.email'      => 'Insira um endereço de e-mail válido.',
        ];
    }
}
