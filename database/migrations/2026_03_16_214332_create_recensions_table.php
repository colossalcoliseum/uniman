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
        Schema::create('recensions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->foreignId('term_paper_id')->constrained('term_papers');
            $table->foreignId('remark_id')->nullable()->constrained('remarks');
            $table->foreignId('reviewer_id')->constrained('users');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->text('final_verdict')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recensions');
    }
};
