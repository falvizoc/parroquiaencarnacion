<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $titulo = fake()->sentence(4);
        $fechaInicio = fake()->dateTimeBetween('now', '+2 months');
        $fechaFin = fake()->boolean(50)
            ? (clone $fechaInicio)->modify('+' . fake()->numberBetween(1, 3) . ' days')
            : null;

        return [
            'titulo' => $titulo,
            'slug' => Str::slug($titulo),
            'descripcion_corta' => fake()->paragraph(),
            'descripcion' => fake()->paragraphs(3, true),
            'imagen' => null,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'hora_inicio' => fake()->time('H:i'),
            'hora_fin' => fake()->optional()->time('H:i'),
            'lugar' => fake()->company(),
            'direccion' => fake()->optional()->address(),
            'categoria' => fake()->randomElement(['liturgico', 'formacion', 'social', 'pastoral', 'especial']),
            'es_destacado' => fake()->boolean(20),
            'activo' => true,
        ];
    }

    public function pasado(): static
    {
        return $this->state(fn (array $attributes) => [
            'fecha_inicio' => fake()->dateTimeBetween('-2 months', '-1 day'),
        ]);
    }

    public function futuro(): static
    {
        return $this->state(fn (array $attributes) => [
            'fecha_inicio' => fake()->dateTimeBetween('+1 day', '+2 months'),
        ]);
    }
}
