<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_days', function (Blueprint $table) {
            $table->id();

            $table->foreignId('schedule_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('specialty_id')
                ->constrained('field_specialties')
                ->cascadeOnDelete();
            $table->date('day_at');
            $table->unsignedSmallInteger('appointment_duration')->default(30);
            // snapshot copies
            $table->json('working_periods')->nullable();
            $table->json('appointments_locations')->nullable();
            $table->boolean('locked')->default(false);
            $table->softDeletes();
            $table->timestamps();

            // 🚀 IMPORTANT: prevent duplicates per schedule/day
            $table->unique(['schedule_id', 'day_at']);
            $table->index(['schedule_id', 'day_at']);
            $table->index(['specialty_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_days');
    }
};
