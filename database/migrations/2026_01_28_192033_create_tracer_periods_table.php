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
        Schema::create('tracer_periods', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_lulusan'); // Cth: "2024" atau "Batch 1 2024"
            $table->string('judul'); // Cth: "Tracer Study Lulusan 2024"
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_periods');
    }
};
