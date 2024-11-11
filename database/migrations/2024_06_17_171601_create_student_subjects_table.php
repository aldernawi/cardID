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
        Schema::create('student_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('student_number');
            $table->foreign('student_number')->references('student_number')->on('students')->onDelete('cascade');
            $table->string('subject_code');
            $table->unique(['student_number', 'subject_code']); // ضمان أن كل طالب لديه كل مادة مرة واحدة فقط
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_subjects');
    }
};
