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
        Schema::create('world_maps', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->foreignId('image_id')
                ->nullable()
                ->constrained('images')
                ->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('location_world_map', function (Blueprint $table) {
            $table->foreignId('world_map_id')
                ->constrained('world_maps')
                ->cascadeOnDelete();

            $table->foreignId('location_id')
                ->constrained('locations')
                ->cascadeOnDelete();

            $table->text('coords')->nullable();

            $table->primary(['world_map_id', 'location_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_world_map');
        Schema::dropIfExists('world_maps');
    }
};
