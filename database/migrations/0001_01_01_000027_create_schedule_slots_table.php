<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_slots', function (Blueprint $table) {

            $table->id();

            $table->foreignId('schedule_day_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('establishment_id')
                ->constrained()
                ->cascadeOnDelete();

            // 👇 IMPORTANT (you used this in logic but missing in migration)
            $table->unsignedSmallInteger('doctor_index');

            $table->time('start_at');
            $table->time('end_at');

            $table->enum('status', ['available', 'booked', 'blocked'])
                ->default('available');

            $table->timestamps();

            // 🚀 performance indexes
            $table->index(['schedule_day_id']);
            $table->index(['status']);
            $table->index(['establishment_id']);

            // 🚨 prevent duplicate slots per doctor/time/day
            $table->unique(
                ['schedule_day_id', 'establishment_id', 'doctor_index', 'start_at'],
                'uq_schedule_slots_main'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_slots');
    }
};
