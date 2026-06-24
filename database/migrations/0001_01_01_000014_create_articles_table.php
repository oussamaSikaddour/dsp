<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('code', 100)->unique();
            $table->text('description')->nullable();

            // BIGINT foreign keys
            $table->unsignedBigInteger('measurement_unit_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();

            $table->decimal('min_quantity', 18, 3)->nullable()->default(0);
            $table->decimal('max_quantity', 18, 3)->nullable();

            $table->boolean('is_active')->default(true);
            $table->boolean('is_imo')->default(false);
            $table->boolean('has_serial_number')->default(false);
            $table->boolean('is_perishable')->default(false);
            $table->boolean('track_lots')->default(false);

            $table->decimal('pmp', 18, 4)->default(0);

            $table->timestamp('last_transaction_date')->nullable();

            $table->softDeletes();
            $table->timestamps();



            // Indexes
            $table->index('name');
            $table->index('is_active');
            $table->index('is_imo');
            $table->index('has_serial_number');
            $table->index('is_perishable');
            $table->index('track_lots');
            $table->index('category_id');
            $table->index('measurement_unit_id');
            $table->index('last_transaction_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
