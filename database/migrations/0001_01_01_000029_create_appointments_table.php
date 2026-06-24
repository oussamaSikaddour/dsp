<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {

            $table->id();
             $table->foreignId('schedule_slot_id')
                ->constrained('schedule_slots')
                ->cascadeOnDelete();

            /*
            | Patient
            */
            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();
            /*
            | Snapshot relations
            */
            $table->foreignId('appointments_location_id')
                ->constrained('establishments')
                ->cascadeOnDelete();

            $table->foreignId('service_id')
                ->constrained('services')
                ->cascadeOnDelete();

            $table->foreignId('specialty_id')
                ->constrained('field_specialties')
                ->cascadeOnDelete();

             $table->foreignId('doctor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            | Metadata
            */
            $table->enum('type', ['initial', 'follow-up'])
                ->default('initial');

            $table->enum('initiator', ['doctor', 'patient'])
                ->default('patient');

            /*
            | Time snapshot
            */
            $table->date('day_at');

            $table->time('start_at')->nullable();
            $table->time('end_at')->nullable();

            $table->softDeletes();
            $table->timestamps();

            /*
            | Indexes
            */
            $table->index(['patient_id']);
            $table->index(['doctor_id']);
            $table->index(['service_id', 'day_at']);
            $table->index(['specialty_id', 'day_at']);
            $table->index(['appointments_location_id', 'day_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
