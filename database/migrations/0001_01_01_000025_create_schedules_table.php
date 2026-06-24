<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            $table->year('year');
            $table->tinyInteger('month'); // 1–12

            $table->string('name_fr')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();

            $table->text('description_fr')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->unsignedSmallInteger('appointment_duration')->default(30);
            $table->enum('state', ['published', 'not_published'])
                ->default('not_published');

            $table->foreignId('service_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('opened_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // 📅 specific dates off
            $table->json('days_off')->nullable();

            // weekly rules (optional future use)
            $table->json('working_days')->nullable();

            // ⏱ time periods
            $table->json('working_periods')->nullable();

            // 📍 locations with capacity
            $table->json('appointments_locations')->nullable();

            // 🔒 NEW: lock system (CRITICAL)
            $table->boolean('locked')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['service_id', 'year', 'month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
