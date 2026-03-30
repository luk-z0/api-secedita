<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CpfValidation;


class AppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id'       => 'required|exists:services,id',
            'citizen_name'     => 'required|string|max:255',
            'cpf'     => [
                'required',
                'string',
                'max:14',
                new CpfValidation()
            ],
            'phone'            => 'required|string',
            'email'            => 'required|email',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
        ];
    }
}
