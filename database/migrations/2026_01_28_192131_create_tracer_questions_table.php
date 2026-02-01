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
        Schema::create('tracer_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_period_id')->constrained()->onDelete('cascade');
            $table->string('kode_dikti')->nullable(); // Cth: f8, f505 (Penting untuk reporting)
            $table->text('pertanyaan');
            // Tipe input untuk menentukan rendering di Livewire
            $table->enum('tipe', ['text', 'number', 'textarea', 'radio', 'checkbox', 'select', 'scale']); 
            $table->integer('urutan')->default(0);
            $table->boolean('wajib_diisi')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_questions');
    }
};
