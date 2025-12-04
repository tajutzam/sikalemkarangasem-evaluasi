<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bukti_dokumen_evaluasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('evaliation_detail_id')
                ->constrained('evaliation_details')
                ->cascadeOnDelete();

            $table->string('file_path');


            $table->timestamps();

            $table->index('evaliation_detail_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_dokumen_evaluasi');
    }
};
