<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Enums\RoleEnum;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = collect(RoleEnum::cases())
            ->map(fn(RoleEnum $role) => [
                'id'         => $role->id(),
                'name'       => $role->value,
                'label'      => $role->label(),
                'level'      => $role->level(),
                'created_at' => now(),
                'updated_at' => now(),
            ])->toArray();

        Role::upsert($roles, ['id'], ['name', 'label', 'level', 'updated_at']);
    }
}
