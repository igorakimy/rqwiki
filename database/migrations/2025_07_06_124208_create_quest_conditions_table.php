<?php

use App\Enums\QuestInteractionTypeEnum;
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
        Schema::create('quest_conditions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conditionable_id');
            $table->string('conditionable_type');
            $table->enum('interaction_type', QuestInteractionTypeEnum::values())
                ->default(QuestInteractionTypeEnum::BRING);
            $table->unsignedInteger('amount')->default(1);
            $table->timestamps();

            $table->foreignId('quest_id')
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quest_conditions');
    }
};
