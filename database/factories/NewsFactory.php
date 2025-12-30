<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        $titulo = fake()->sentence(6);

        return [
            'titulo' => $titulo,
            'slug' => Str::slug($titulo),
            'extracto' => fake()->paragraph(),
            'contenido' => fake()->paragraphs(5, true),
            'imagen' => null,
            'categoria' => fake()->randomElement(['parroquia', 'diocesis', 'papa', 'comunidad', 'general']),
            'autor' => fake()->optional()->name(),
            'fecha_publicacion' => fake()->dateTimeBetween('-1 month', 'now'),
            'es_destacado' => fake()->boolean(20),
            'activo' => true,
        ];
    }

    public function destacado(): static
    {
        return $this->state(fn (array $attributes) => [
            'es_destacado' => true,
        ]);
    }

    public function inactivo(): static
    {
        return $this->state(fn (array $attributes) => [
            'activo' => false,
        ]);
    }
}
