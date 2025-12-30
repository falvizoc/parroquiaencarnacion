<?php

namespace Tests\Unit\Models;

use App\Models\FaithfulMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaithfulMemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_fiel(): void
    {
        $fiel = FaithfulMember::factory()->create([
            'nombre' => 'Juan',
            'apellido_paterno' => 'Pérez',
            'email' => 'juan@ejemplo.com',
        ]);

        $this->assertDatabaseHas('faithful_members', [
            'nombre' => 'Juan',
            'email' => 'juan@ejemplo.com',
        ]);
    }

    public function test_accessor_nombre_completo(): void
    {
        $fiel = FaithfulMember::factory()->create([
            'nombre' => 'Juan',
            'apellido_paterno' => 'Pérez',
            'apellido_materno' => 'García',
        ]);

        $this->assertEquals('Juan Pérez García', $fiel->nombre_completo);
    }

    public function test_accessor_nombre_completo_sin_materno(): void
    {
        $fiel = FaithfulMember::factory()->create([
            'nombre' => 'Juan',
            'apellido_paterno' => 'Pérez',
            'apellido_materno' => null,
        ]);

        $this->assertEquals('Juan Pérez', $fiel->nombre_completo);
    }

    public function test_scope_activo(): void
    {
        FaithfulMember::factory()->create(['activo' => true]);
        FaithfulMember::factory()->create(['activo' => false]);

        $activos = FaithfulMember::activo()->count();

        $this->assertEquals(1, $activos);
    }

    public function test_scope_verificado(): void
    {
        FaithfulMember::factory()->create(['email_verificado_at' => now()]);
        FaithfulMember::factory()->create(['email_verificado_at' => null]);

        $verificados = FaithfulMember::verificado()->count();

        $this->assertEquals(1, $verificados);
    }

    public function test_generar_token_verificacion(): void
    {
        $fiel = FaithfulMember::factory()->create([
            'token_verificacion' => null,
        ]);

        $token = $fiel->generarTokenVerificacion();

        $this->assertNotEmpty($token);
        $this->assertEquals(64, strlen($token));
        $this->assertEquals($token, $fiel->fresh()->token_verificacion);
    }

    public function test_generar_token_preferencias(): void
    {
        $fiel = FaithfulMember::factory()->create([
            'token_preferencias' => null,
        ]);

        $token = $fiel->generarTokenPreferencias();

        $this->assertNotEmpty($token);
        $this->assertEquals(64, strlen($token));
    }
}
