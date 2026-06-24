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
        Schema::create('medical_exams', function (Blueprint $table) {
           $table->id();
                $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->foreignId('specialty_id')
                ->constrained('field_specialties')
                ->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->longText('report_fr');
            $table->longText('report_ar')->nullable();
            $table->longText('report_en')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_exams');
    }
};
