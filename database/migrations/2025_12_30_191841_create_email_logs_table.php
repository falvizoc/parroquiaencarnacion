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
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_campaign_id')->constrained()->cascadeOnDelete();
            $table->foreignId('faithful_member_id')->constrained()->cascadeOnDelete();
            $table->string('email');
            $table->enum('estado', ['pendiente', 'enviado', 'fallido', 'rebotado'])->default('pendiente');
            $table->text('error')->nullable();
            $table->timestamp('enviado_at')->nullable();
            $table->timestamps();

            $table->index(['email_campaign_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
