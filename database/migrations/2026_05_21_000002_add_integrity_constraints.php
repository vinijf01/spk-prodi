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
        // Add Foreign Keys to Preferensi
        Schema::table('preferensi', function (Blueprint $table) {
            $table->foreign('kriteria_1')->references('id')->on('kriteria')->onDelete('cascade');
            $table->foreign('kriteria_2')->references('id')->on('kriteria')->onDelete('cascade');
        });

        // Add Unique Constraint to Pilihans
        Schema::table('pilihans', function (Blueprint $table) {
            $table->unique(['id_sekolah', 'id_prodi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('preferensi', function (Blueprint $table) {
            $table->dropForeign(['kriteria_1']);
            $table->dropForeign(['kriteria_2']);
        });

        Schema::table('pilihans', function (Blueprint $table) {
            $table->dropUnique(['id_sekolah', 'id_prodi']);
        });
    }
};
