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
        Schema::create('crypt_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('imagen_banner')->nullable();
            $table->string('color_fondo')->default('#f59e0b'); // amber-500
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('texto_boton')->nullable();
            $table->string('url_boton')->nullable(); // Para link externo o ancla
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypt_campaigns');
    }
};
