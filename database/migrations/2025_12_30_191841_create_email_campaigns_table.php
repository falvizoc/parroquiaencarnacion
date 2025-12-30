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
        Schema::create('email_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('email_template_id')->nullable()->constrained()->nullOnDelete();
            $table->string('asunto');
            $table->text('contenido');
            $table->enum('tipo', ['newsletter', 'evento', 'aviso', 'personalizado'])->default('personalizado');

            // Segmentación
            $table->json('segmentacion')->nullable(); // Filtros: capilla, genero, etc.

            // Estado y programación
            $table->enum('estado', ['borrador', 'programada', 'enviando', 'enviada', 'cancelada'])->default('borrador');
            $table->timestamp('programada_para')->nullable();
            $table->timestamp('enviada_at')->nullable();

            // Estadísticas
            $table->unsignedInteger('total_destinatarios')->default(0);
            $table->unsignedInteger('enviados')->default(0);
            $table->unsignedInteger('fallidos')->default(0);

            // Auditoría
            $table->foreignId('creado_por')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_campaigns');
    }
};
