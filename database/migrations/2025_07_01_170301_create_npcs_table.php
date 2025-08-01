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
        Schema::create('npcs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();

            $table->foreignId('image_id')
                ->constrained('images')
                ->nullOnDelete();

            $table->timestamps();
        });

        Schema::create('location_npcs', function (Blueprint $table) {
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            $table->foreignId('npc_id')->constrained()->cascadeOnDelete();

            $table->primary(['location_id', 'npc_id']);
        });

        Schema::create('npc_npc_group', function (Blueprint $table) {
            $table->foreignId('npc_id')->constrained()->cascadeOnDelete();
            $table->foreignId('npc_group_id')->constrained()->cascadeOnDelete();

            $table->primary(['npc_id', 'npc_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_npcs');
        Schema::dropIfExists('npc_npc_group');
        Schema::dropIfExists('npcs');
    }
};
