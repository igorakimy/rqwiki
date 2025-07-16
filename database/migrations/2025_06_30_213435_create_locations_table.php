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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('location_type_id');
            $table->text('coords')->nullable();
            $table->timestamps();

            $table->foreign('location_type_id')
                ->references('id')
                ->on('location_types')
                ->onDelete('cascade');

            $table->foreignId('image_id')
                ->nullable()
                ->constrained('images')
                ->nullOnDelete();
        });

        Schema::create('location_location_type', function (Blueprint $table) {
            $table->foreignId('location_id')
                ->constrained('locations')
                ->cascadeOnDelete();

            $table->foreignId('location_type_id')
                ->constrained('location_types')
                ->cascadeOnDelete();

            $table->primary(['location_id', 'location_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_location_type');
        Schema::dropIfExists('locations');
    }
};
