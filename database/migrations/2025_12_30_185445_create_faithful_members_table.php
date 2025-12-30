<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('faithful_members', function (Blueprint $table) {
            $table->id();

            // Datos personales
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('genero', ['masculino', 'femenino', 'otro'])->nullable();

            // Contacto
            $table->string('email')->unique();
            $table->string('telefono')->nullable();
            $table->string('telefono_emergencia')->nullable();
            $table->text('direccion')->nullable();
            $table->string('colonia')->nullable();
            $table->string('codigo_postal')->nullable();

            // Información parroquial
            $table->foreignId('chapel_id')->nullable()->constrained()->nullOnDelete();
            $table->date('fecha_bautismo')->nullable();
            $table->date('fecha_confirmacion')->nullable();
            $table->date('fecha_primera_comunion')->nullable();
            $table->enum('estado_civil', ['soltero', 'casado_iglesia', 'casado_civil', 'divorciado', 'viudo', 'union_libre'])->nullable();
            $table->text('notas')->nullable();

            // Estado y verificación
            $table->boolean('activo')->default(true);
            $table->timestamp('email_verificado_at')->nullable();
            $table->string('token_verificacion')->nullable()->unique();

            // Preferencias de comunicación
            $table->boolean('recibir_newsletter')->default(true);
            $table->boolean('recibir_eventos')->default(true);
            $table->boolean('recibir_avisos')->default(true);
            $table->json('preferencias_adicionales')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['apellido_paterno', 'apellido_materno', 'nombre']);
            $table->index('fecha_nacimiento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faithful_members');
    }
};
