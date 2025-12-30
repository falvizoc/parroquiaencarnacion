<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migración.
     */
    public function up(): void
    {
        Schema::create('mass_schedules', function (Blueprint $table) {
            $table->id();

            // Día de la semana (0=Domingo, 1=Lunes, ..., 6=Sábado)
            $table->unsignedTinyInteger('dia_semana');

            // Hora de la misa
            $table->time('hora');

            // Tipo de misa
            $table->string('tipo')->default('ordinaria');
            // Valores: ordinaria, dominical, vespertina, especial

            // Descripción adicional (opcional)
            $table->string('descripcion')->nullable();

            // Ubicación dentro de la parroquia
            $table->string('ubicacion')->default('Templo Principal');

            // Idioma de la misa
            $table->string('idioma')->default('es');

            // Si está activo o no
            $table->boolean('activo')->default(true);

            // Notas adicionales
            $table->text('notas')->nullable();

            // Orden para mostrar
            $table->unsignedInteger('orden')->default(0);

            $table->timestamps();

            // Índices
            $table->index(['dia_semana', 'hora']);
            $table->index('activo');
        });
    }

    /**
     * Revertir la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('mass_schedules');
    }
};
