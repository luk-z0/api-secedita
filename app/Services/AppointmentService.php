<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Validation\ValidationException;

class AppointmentService
{

    public function listAllAppointments()
    {
        return Appointment::with('service')
            ->latest()
            ->paginate(15);
    }

    public function createAppointment(array $data)
    {
        $exists = Appointment::where('service_id', $data['service_id'])
            ->where('appointment_date', $data['appointment_date'])
            ->where('appointment_time', $data['appointment_time'])
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'appointment_time' => 'Este horário já está ocupado para este serviço.'
            ]);
        }

        return Appointment::create($data);
    }

    public function updateStatus(Appointment $appointment, string $status)
    {
        $appointment->update(['status' => $status]);
        return $appointment;
    }

    public function restoreAppointment(Appointment $appointment)
    {
        $appointment->restore();
        return $appointment;
    }
}
