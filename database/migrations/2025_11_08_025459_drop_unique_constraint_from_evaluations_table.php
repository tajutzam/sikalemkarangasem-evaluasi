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
        Schema::table('evaluations', function (Blueprint $table) {
            // Drop unique constraint untuk memungkinkan duplikasi tahun yang sama jika status = rejected
            $table->dropUnique(['instansi_id', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            // Restore unique constraint jika rollback
            $table->unique(['instansi_id', 'tahun']);
        });
    }
};
