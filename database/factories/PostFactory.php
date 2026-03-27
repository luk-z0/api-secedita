<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'        => fake()->sentence(),
            'summary'      => fake()->paragraph(2),
            'content'      => fake()->paragraphs(5, true),
            'image_url'    => fake()->imageUrl(800, 600, 'education'),
            'file_url'     => null,
            'category'     => fake()->randomElement(['Notícias', 'Eventos', 'Comunicados']),
            'sub_category' => fake()->word(),
            'department'   => 'Secretaria de Educação',
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'status'       => fake()->randomElement(['draft', 'published']),
            'user_id' => \App\Models\User::inRandomOrder()->first()->id ?? \App\Models\User::factory(),
        ];
    }
}
