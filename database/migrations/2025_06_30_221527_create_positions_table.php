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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->integer('top')->nullable();
            $table->integer('left')->nullable();
            $table->integer('right')->nullable();
            $table->integer('bottom')->nullable();
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('positionable_id');
            $table->string('positionable_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
