<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        // Pega o primeiro serviço ativo para vincular
        $service = Service::where('is_active', true)->first();

        if ($service) {
            Appointment::create([
                'service_id' => $service->id,
                'citizen_name' => 'Lucas Developer',
                'cpf' => '123.456.789-00',
                'phone' => '81999999999',
                'email' => 'lucas@exemplo.com',
                'appointment_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'appointment_time' => '10:00',
                'status' => 'pending',
            ]);

            Appointment::create([
                'service_id' => $service->id,
                'citizen_name' => 'Maria Silva',
                'cpf' => '987.654.321-00',
                'phone' => '81888888888',
                'email' => 'maria@exemplo.com',
                'appointment_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'appointment_time' => '14:30',
                'status' => 'confirmed',
            ]);
        }
    }
}
