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
        Schema::create('patients', function (Blueprint $table) {

            $table->id();

            $table->string('code')->unique();

            $table->string('last_name_fr');
            $table->string('first_name_fr');

            $table->string('last_name_ar')->nullable();
            $table->string('first_name_ar')->nullable();

            $table->enum('gender', ['male', 'female', 'other'])->nullable();

            $table->string('birth_place_fr')->nullable();
            $table->string('birth_place_ar')->nullable();
            $table->string('birth_place_en')->nullable();

            $table->date('birth_date')->nullable();

            $table->string('address_fr')->nullable();
            $table->string('address_ar')->nullable();
            $table->string('address_en')->nullable();

            $table->foreignId('commune_id')
                ->nullable()
                ->constrained('communes')
                ->nullOnDelete();

            $table->foreignId('father_id')
                ->nullable()
                ->constrained('patients')
                ->nullOnDelete();

            $table->foreignId('mother_id')
                ->nullable()
                ->constrained('patients')
                ->nullOnDelete();

            $table->string('tel')->nullable();

            $table->string('insurance_number')->nullable();

            $table->foreignId('opened_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->softDeletes();
            $table->timestamps();

            $table->index('code');
            $table->index('commune_id');
            $table->index('father_id');
            $table->index('mother_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
