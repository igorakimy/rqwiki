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
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->tinyInteger('required_level')->default(1);
            $table->unsignedInteger('gold')->default(0);
            $table->unsignedInteger('experience')->default(0);
            $table->text('condition')->nullable();
            $table->text('condition_description');
            $table->text('explanation')->nullable();

            $table->foreignId('quest_type_id')
                ->constrained('quest_types')
                ->cascadeOnDelete();

            $table->foreignId('quest_chain_id')
                ->nullable()
                ->constrained('quest_chains')
                ->cascadeOnDelete();

            $table->foreignId('npc_from_id')
                ->nullable()
                ->constrained('npcs')
                ->cascadeOnDelete();

            $table->foreignId('npc_to_id')
                ->nullable()
                ->constrained('npcs')
                ->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('quest_prerequisite', function (Blueprint $table) {
            $table->foreignId('quest_id')
                ->constrained('quests')
                ->cascadeOnDelete();

            $table->foreignId('prev_quest_id')
                ->constrained('quests')
                ->cascadeOnDelete();

            $table->primary(['quest_id', 'prev_quest_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quest_prerequisite');
        Schema::dropIfExists('quests');
    }
};
