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
        Schema::create('faithful_member_parish_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faithful_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parish_group_id')->constrained()->cascadeOnDelete();
            $table->date('fecha_ingreso')->nullable();
            $table->string('rol')->nullable(); // miembro, coordinador, secretario, etc.
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->unique(['faithful_member_id', 'parish_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faithful_member_parish_group');
    }
};
