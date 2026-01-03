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
        Schema::create('translation_logs', function (Blueprint $table) {
            $table->id();
            $table->string('translatable_type'); // Tipo de modelo (App\Models\News, etc.)
            $table->unsignedBigInteger('translatable_id'); // ID del registro
            $table->string('field'); // Campo traducido
            $table->string('source_locale', 10)->default('es');
            $table->string('target_locale', 10)->default('en');
            $table->longText('source_text');
            $table->longText('translated_text')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->integer('tokens_used')->nullable();
            $table->decimal('cost_usd', 10, 6)->nullable();
            $table->timestamps();

            // Índices para consultas eficientes
            $table->index(['translatable_type', 'translatable_id'], 'translation_logs_morph_index');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translation_logs');
    }
};
