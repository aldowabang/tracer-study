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
        Schema::create('tracer_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_question_id')->constrained('tracer_questions')->onDelete('cascade');
            $table->string('label'); // Cth: "Sangat Erat", "Bekerja Full Time"
            $table->string('value')->nullable(); // Nilai untuk scoring/kode
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_options');
    }
};
