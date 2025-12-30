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
        Schema::table('faithful_members', function (Blueprint $table) {
            $table->string('token_preferencias', 64)->nullable()->unique()->after('token_verificacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faithful_members', function (Blueprint $table) {
            $table->dropColumn('token_preferencias');
        });
    }
};
