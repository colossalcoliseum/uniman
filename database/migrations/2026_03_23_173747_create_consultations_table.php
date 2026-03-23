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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('term_paper_id')->constrained('term_papers');
            $table->foreignId('teacher_id')->constrained('users');
            $table->foreignId('student_id')->constrained('users');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->enum('type', ['in_person', 'online'])->default('online');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->string('location');
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
