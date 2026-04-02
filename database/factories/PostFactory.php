<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
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
        $temas = ['education', 'school', 'classroom', 'teacher', 'students', 'learning'];
        $keyword = fake()->randomElement($temas);

        $imageUrl = "https://images.unsplash.com/photo-" . fake()->numberBetween(1500000000000, 1600000000000) . "?auto=format&fit=crop&q=80&w=800&h=600&keyword={$keyword}";

        return [
            'title'        => fake()->randomElement([
                'Inauguração da nova Escola Municipal em Itapissuma',
                'Secretaria de Educação anuncia novo calendário escolar',
                'Professores da rede municipal participam de capacitação',
                'Alunos de Itapissuma se destacam em Olimpíada de Matemática',
                'Projeto de leitura nas escolas amplia acervo bibliográfico',
            ]) . ' - ' . fake()->sentence(3),
            'summary'      => 'A Prefeitura de Itapissuma, através da SEDUC, informa: ' . fake()->paragraph(2),
            'content'      => fake()->paragraphs(5, true),
            'image_url'    => $imageUrl,
            'file_url'     => null,
            'category'     => fake()->randomElement(['Notícias', 'Eventos', 'Comunicados']),
            'sub_category' => fake()->randomElement(['Ensino Fundamental', 'Educação Infantil', 'EJA', 'Esportes']),
            'department'   => 'Secretaria de Educação',
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'status'       => 'published',
            'user_id'      =>  User::factory(),
        ];
    }
}
