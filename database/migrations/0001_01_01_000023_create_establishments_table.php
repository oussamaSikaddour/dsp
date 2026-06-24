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
        Schema::create('establishments', function (Blueprint $table) {
            $table->id();
            $table->string('acronym')->nullable();

            // Localized names
            $table->string('name_fr')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();

            $table->string('email')->nullable();

            // Localized addresses
            $table->string('address_fr')->nullable();
            $table->string('address_en')->nullable();
            $table->string('address_ar')->nullable();

            // Localized descriptions
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();

            $table->string('tel')->nullable();
            $table->string('fax')->nullable();

            $table->foreignId('daira_id')
                  ->constrained('dairates')
                  ->cascadeOnDelete();

            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();

            $table->json('types')->nullable(); // store array of types like ["class_a", "appointment_locations"]

            $table->softDeletes(); // adds deleted_at timestamp
            $table->timestamps(); // adds created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('establishments');
    }
};
