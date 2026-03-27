<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'cpf' => $this->generateCpf(),
            'position' => fake()->jobTitle(),
            'is_active' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    private function generateCpf(): string
    {
        $n = array_map(fn() => rand(0, 9), range(1, 9));

        // Cálculo do 1º dígito verificador
        $d1 = 0;
        foreach ([10, 9, 8, 7, 6, 5, 4, 3, 2] as $i => $v) $d1 += $n[$i] * $v;
        $d1 = 11 - ($d1 % 11);
        if ($d1 >= 10) $d1 = 0;
        $n[] = $d1;

        // Cálculo do 2º dígito verificador
        $d2 = 0;
        foreach ([11, 10, 9, 8, 7, 6, 5, 4, 3, 2] as $i => $v) $d2 += $n[$i] * $v;
        $d2 = 11 - ($d2 % 11);
        if ($d2 >= 10) $d2 = 0;
        $n[] = $d2;

        return implode('', $n);
    }
}
