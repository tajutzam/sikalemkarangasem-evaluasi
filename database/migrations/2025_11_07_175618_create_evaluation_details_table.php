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
        Schema::create('evaliation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_id')->constrained('evaluations')->cascadeOnDelete();
            $table->foreignId('variabel_id')->constrained('variabel')->cascadeOnDelete();
            $table->foreignId('tingkat_id')->nullable()->constrained('tingkat')->nullOnDelete();
            $table->string('bukti_dokumen')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('evaluation_id');
            $table->index(['evaluation_id', 'variabel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaliation_details');
    }
};