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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id')->constrained('instansi')->cascadeOnDelete();
            $table->year('tahun');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft');
            $table->timestamps();

            // Unique constraint: satu instansi hanya bisa punya 1 evaluasi per tahun
            $table->unique(['instansi_id', 'tahun']);
            $table->index(['instansi_id', 'tahun']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};