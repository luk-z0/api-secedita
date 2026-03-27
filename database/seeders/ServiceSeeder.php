<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Bolsa Escola Municipal',
                'sector' => 'Secretaria de Educação',
                'description' => 'Programa de auxílio permanência para alunos da rede municipal.',
                'is_active' => true,
            ],
            [
                'name' => 'Matrícula 2026',
                'sector' => 'Gestão Escolar',
                'description' => 'Agendamento para entrega de documentação de novos alunos.',
                'is_active' => true,
            ],
            [
                'name' => 'Solicitação de Histórico',
                'sector' => 'Secretaria Acadêmica',
                'description' => 'Pedido de documento oficial de conclusão de curso.',
                'is_active' => false, 
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
