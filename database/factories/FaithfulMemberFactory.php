<?php

namespace Database\Factories;

use App\Models\FaithfulMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FaithfulMember>
 */
class FaithfulMemberFactory extends Factory
{
    protected $model = FaithfulMember::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->firstName(),
            'apellido_paterno' => fake()->lastName(),
            'apellido_materno' => fake()->optional(0.8)->lastName(),
            'fecha_nacimiento' => fake()->optional()->dateTimeBetween('-80 years', '-18 years'),
            'genero' => fake()->randomElement(['masculino', 'femenino']),
            'email' => fake()->unique()->safeEmail(),
            'telefono' => fake()->optional()->phoneNumber(),
            'telefono_emergencia' => fake()->optional(0.3)->phoneNumber(),
            'direccion' => fake()->optional()->streetAddress(),
            'colonia' => fake()->optional()->citySuffix(),
            'codigo_postal' => fake()->optional()->postcode(),
            'chapel_id' => null,
            'fecha_bautismo' => fake()->optional(0.7)->dateTimeBetween('-50 years', '-1 year'),
            'fecha_confirmacion' => fake()->optional(0.5)->dateTimeBetween('-40 years', '-1 year'),
            'fecha_primera_comunion' => fake()->optional(0.6)->dateTimeBetween('-50 years', '-1 year'),
            'estado_civil' => fake()->optional()->randomElement(array_keys(FaithfulMember::ESTADOS_CIVILES)),
            'notas' => fake()->optional(0.2)->sentence(),
            'activo' => true,
            'email_verificado_at' => fake()->optional(0.7)->dateTimeBetween('-1 year', 'now'),
            'token_verificacion' => null,
            'recibir_newsletter' => fake()->boolean(80),
            'recibir_eventos' => fake()->boolean(70),
            'recibir_avisos' => fake()->boolean(60),
            'preferencias_adicionales' => null,
            'token_preferencias' => null,
        ];
    }

    public function verificado(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verificado_at' => now(),
            'token_verificacion' => null,
        ]);
    }

    public function noVerificado(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verificado_at' => null,
        ]);
    }

    public function inactivo(): static
    {
        return $this->state(fn (array $attributes) => [
            'activo' => false,
        ]);
    }

    public function conNewsletter(): static
    {
        return $this->state(fn (array $attributes) => [
            'recibir_newsletter' => true,
            'email_verificado_at' => now(),
        ]);
    }

    public function sinNewsletter(): static
    {
        return $this->state(fn (array $attributes) => [
            'recibir_newsletter' => false,
        ]);
    }
}
