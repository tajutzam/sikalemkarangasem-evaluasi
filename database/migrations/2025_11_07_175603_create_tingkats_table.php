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
        Schema::create('tingkat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variabel_id')->constrained('variabel')->cascadeOnDelete();
            $table->integer('tingkat'); // 1-5
            $table->text('deskripsi_indikator');
            $table->timestamps();

            $table->index(['variabel_id', 'tingkat']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tingkat');
    }
};
