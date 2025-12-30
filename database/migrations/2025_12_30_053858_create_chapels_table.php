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
        Schema::create('chapels', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('imagen')->nullable();
            $table->string('mapa_url')->nullable(); // Google Maps embed URL
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->boolean('activo')->default(true);
            $table->integer('orden')->default(0);
            $table->timestamps();
        });

        // Add chapel_id to mass_schedules
        Schema::table('mass_schedules', function (Blueprint $table) {
            $table->foreignId('chapel_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });

        // Add chapel_id to parish_groups
        Schema::table('parish_groups', function (Blueprint $table) {
            $table->foreignId('chapel_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parish_groups', function (Blueprint $table) {
            $table->dropForeign(['chapel_id']);
            $table->dropColumn('chapel_id');
        });

        Schema::table('mass_schedules', function (Blueprint $table) {
            $table->dropForeign(['chapel_id']);
            $table->dropColumn('chapel_id');
        });

        Schema::dropIfExists('chapels');
    }
};
