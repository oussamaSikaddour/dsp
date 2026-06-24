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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->nullable();
            $table->string('name_fr')->nullable();
            $table->string('name_en')->nullable();
            $table->foreignId('head_of_service_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->string('type')->nullable();
             $table->string('tel')->nullable();
            $table->string('fax')->nullable();
            $table->foreignId('establishment_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('specialty_id')
                  ->constrained('field_specialties')
                  ->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
