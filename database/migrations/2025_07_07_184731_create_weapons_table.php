<?php

use App\Enums\EquipmentItemClassEnum;
use App\Enums\GenderEnum;
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
        Schema::create('weapons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('weapon_type_id');
            $table->enum('item_class', EquipmentItemClassEnum::values())
                ->default(EquipmentItemClassEnum::C);
            $table->tinyInteger('required_level')->default(1);
            $table->tinyInteger('max_slots_amount')->default(1);
            $table->integer('attack')->default(0);
            $table->double('attack_speed')->default(0.0);
            $table->integer('dps')->default(0);
            $table->integer('defence')->nullable();
            $table->enum('gender', GenderEnum::values())
                ->default(GenderEnum::ANY->value);
            $table->integer('selling_price')->default(1);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('weapon_type_id')
                ->references('id')
                ->on('weapon_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weapons');
    }
};
