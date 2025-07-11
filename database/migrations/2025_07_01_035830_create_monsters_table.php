<?php

use App\Enums\MonsterDefenceEnum;
use App\Enums\MonsterModeEnum;
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
        Schema::create('monsters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedTinyInteger('level')->default(1);
            $table->unsignedInteger('health_points')->default(1);
            $table->unsignedTinyInteger('element_strength')->default(0);
            $table->boolean('is_aggressive')->default(false);
            $table->boolean('is_elite')->default(false);
            $table->boolean('is_boss')->default(false);
            $table->boolean('pick_up_loot')->default(false);
            $table->unsignedInteger('shield')->nullable();
            $table->enum('defence', MonsterDefenceEnum::values())->default(MonsterDefenceEnum::NO_DEF->value);
            $table->unsignedInteger('experience')->default(0);
            $table->decimal('xp_per_hp')->default(0.00);
            $table->enum('combat_mode', MonsterModeEnum::values())->default(MonsterModeEnum::MELEE->value);
            $table->boolean('quest_only')->default(false);
            $table->timestamps();

            $table->foreignId('race_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('element_id')
                ->constrained()
                ->cascadeOnDelete();
        });

        Schema::create('monster_has_called_monsters', function (Blueprint $table) {
            $table->unsignedBigInteger('monster_id');
            $table->unsignedBigInteger('called_monster_id');

            $table->foreign('monster_id')
                ->references('id')
                ->on('monsters')
                ->onDelete('cascade');

            $table->foreign('called_monster_id')
                ->references('id')
                ->on('monsters')
                ->onDelete('cascade');

            $table->primary(['monster_id', 'called_monster_id']);
        });

        Schema::create('location_monsters', function (Blueprint $table) {
            $table->unsignedBigInteger('monster_id');
            $table->unsignedBigInteger('location_id');
            $table->smallInteger('respawn_time')->default(0);

            $table->foreign('monster_id')
                ->references('id')
                ->on('monsters')
                ->onDelete('cascade');

            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('cascade');

            $table->primary(['monster_id', 'location_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monsters');
    }
};
