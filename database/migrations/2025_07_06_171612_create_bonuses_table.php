<?php

use App\Enums\BonusesValueTypeEnum;
use App\Enums\SealColorEnum;
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
        Schema::create('bonuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('name_formatted');
            $table->string('name_alt')->nullable();
            $table->string('name_alt_formatted')->nullable();
            $table->boolean('is_pvp')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('bonusables', function (Blueprint $table) {
            $table->unsignedBigInteger('bonus_id');
            $table->unsignedBigInteger('bonusable_id');
            $table->string('bonusable_type');
            $table->integer('value')->default(0)->nullable();
            $table->enum('value_type', BonusesValueTypeEnum::values())
                ->default(BonusesValueTypeEnum::ACTUAL->value);
            $table->unsignedInteger('duration')->default(0);
            $table->boolean('use_alt_name')->default(false);
            $table->text('special_property')->nullable();
            $table->json('additional_properties')->nullable();
            $table->integer('order')->default(0);
            $table->enum('seal_color', SealColorEnum::values())->nullable();

            $table->foreign('bonus_id')
                ->references('id')
                ->on('bonuses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonuses');
    }
};
