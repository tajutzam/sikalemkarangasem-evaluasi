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
        Schema::create('variabel', function (Blueprint $table) {
            $table->id();
            $table->string('kode_variabel', 10); // I, II, III, dst
            $table->text('nama_variabel');
            $table->integer('urutan');
            $table->timestamps();

            $table->index('urutan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variabel');
    }
};