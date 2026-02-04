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
        if (!Schema::hasTable('tracer_participations')) {
            Schema::create('tracer_participations', function (Blueprint $table) {
                $table->id();
                
                // Relasi ke Periode dan User
                $table->foreignId('tracer_period_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                
                // Status Pengerjaan
                // Default 'belum_selesai' saat user pertama kali buka kuesioner
                $table->enum('status', ['belum_selesai', 'selesai_isi', 'selesai_cek'])->default('belum_selesai');
                
                $table->timestamps(); // created_at = waktu mulai, updated_at = waktu selesai
                
                // PENTING: Mencegah duplikasi data
                // Satu user hanya boleh punya satu status di satu periode
                $table->unique(['tracer_period_id', 'user_id']); 
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_participations');
    }
};
