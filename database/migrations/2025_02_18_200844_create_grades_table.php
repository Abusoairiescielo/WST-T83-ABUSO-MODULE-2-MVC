public function up()
{
    Schema::create('grades', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
        $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
        $table->decimal('midterm', 5, 2)->nullable();
        $table->decimal('finals', 5, 2)->nullable();
        $table->decimal('average', 5, 2)->nullable();
        $table->string('remarks')->nullable();
        $table->timestamps();
        
        // Ensure one grade entry per student per subject
        $table->unique(['student_id', 'subject_id']);
    });
}<?php

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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->decimal('midterm', 5, 2)->nullable();
            $table->decimal('finals', 5, 2)->nullable();
            $table->decimal('average', 5, 2)->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
            
            // Ensure one grade entry per student per subject
            $table->unique(['student_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};