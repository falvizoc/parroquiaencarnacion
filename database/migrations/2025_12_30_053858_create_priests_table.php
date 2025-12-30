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
        Schema::create('priests', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->string('cargo'); // parroco, vicario
            $table->string('titulo')->nullable(); // Pbro., Mons., etc.
            $table->text('mensaje')->nullable(); // Mensaje personal del sacerdote
            $table->text('biografia')->nullable();
            $table->string('foto')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->date('fecha_ordenacion')->nullable();
            $table->date('fecha_asignacion')->nullable(); // Fecha de asignación a la parroquia
            $table->boolean('activo')->default(true);
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priests');
    }
};
