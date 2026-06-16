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
            $table->foreignId('term_paper_id')->constrained('term_papers');
            $table->foreignId('teacher_id')->constrained('users');
            $table->foreignId('student_id')->constrained('users');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->string('type')->default('online');
            $table->string('status')->default('pending');
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('attended')->nullable();
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
