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
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('quest_type_id');
            $table->unsignedBigInteger('quest_chain_id');
            $table->unsignedBigInteger('npc_from_id');
            $table->unsignedBigInteger('npc_to_id');
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('quests')
                ->onDelete('cascade');

            $table->foreign('quest_type_id')
                ->references('id')
                ->on('quest_types')
                ->onDelete('cascade');

            $table->foreign('quest_chain_id')
                ->references('id')
                ->on('quest_chains')
                ->onDelete('cascade');

            $table->foreign('npc_from_id')
                ->references('id')
                ->on('npcs')
                ->onDelete('cascade');

            $table->foreign('npc_from_id')
                ->references('id')
                ->on('npcs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quests');
    }
};
