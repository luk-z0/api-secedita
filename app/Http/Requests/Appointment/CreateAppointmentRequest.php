<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CpfValidation;

class CreateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id'       => 'required|exists:services,id',
            'citizen_name'     => 'required|string|min:3|max:255',
            'cpf'     => [
                'required',
                'string',
                'max:14',
                new CpfValidation()
            ],
            'phone'            => 'required|string|min:10|max:15',
            'email'            => 'required|email|max:255',
            'appointment_date' => 'required|date|after_or_equal:today', // Não permite agendar no passado
            'appointment_time' => 'required|string',
            'status'           => 'nullable|in:pending,confirmed,canceled',
        ];
    }

    public function messages(): array
    {
        return [
            'service_id.exists'         => 'O serviço selecionado é inválido.',
            'appointment_date.after_or_equal' => 'A data do agendamento não pode ser anterior a hoje.',
            'email.email'               => 'Insira um endereço de e-mail válido.',
            'citizen_name.min'          => 'O nome deve ter pelo menos 3 caracteres.',
        ];
    }
}
