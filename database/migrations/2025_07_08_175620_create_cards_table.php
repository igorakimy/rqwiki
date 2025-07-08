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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->tinyInteger('signs_cost')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('card_equipment_types', function (Blueprint $table) {
            $table->unsignedBigInteger('card_id');
            $table->unsignedBigInteger('equipment_type_id');

            $table->primary(['card_id', 'equipment_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
