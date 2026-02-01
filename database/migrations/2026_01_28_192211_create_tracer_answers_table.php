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
        Schema::create('tracer_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_period_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Alumni yg mengisi
            $table->foreignId('tracer_question_id')->constrained('tracer_questions')->onDelete('cascade');
            
            // Jika jawaban berupa pilihan ganda
            $table->foreignId('tracer_option_id')->nullable()->constrained('tracer_options')->onDelete('set null');
            
            // Jika jawaban berupa isian teks/angka
            $table->text('jawaban_text')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_answers');
    }
};
