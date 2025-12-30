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
        Schema::create('parish_groups', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->text('descripcion_corta')->nullable();
            $table->longText('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->unsignedTinyInteger('dia_reunion')->nullable(); // 0=Dom, 1=Lun...
            $table->time('hora_reunion')->nullable();
            $table->string('lugar_reunion')->nullable();
            $table->string('coordinador_nombre')->nullable();
            $table->string('coordinador_telefono')->nullable();
            $table->string('coordinador_email')->nullable();
            $table->boolean('activo')->default(true);
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parish_groups');
    }
};
