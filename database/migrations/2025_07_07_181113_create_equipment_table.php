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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('item_class', EquipmentItemClassEnum::values())
                ->default(EquipmentItemClassEnum::C);
            $table->tinyInteger('required_level')->default(1);
            $table->tinyInteger('max_slots_amount')->default(1);
            $table->integer('defence')->nullable();
            $table->enum('gender', GenderEnum::values())
                ->default(GenderEnum::ANY->value);
            $table->integer('selling_price')->default(1);
            $table->text('description')->nullable();

            $table->foreignId('equipment_type_id')
                ->constrained('equipment_types')
                ->cascadeOnDelete();

            $table->foreignId('image_id')
                ->nullable()
                ->constrained('images')
                ->nullOnDelete();

            $table->timestamps();
        });

        Schema::create('class_equipment', function (Blueprint $table) {
            $table->foreignId('class_id')
                ->constrained('classes')
                ->cascadeOnDelete();

            $table->foreignId('equipment_id')
                ->constrained('equipment')
                ->cascadeOnDelete();

            $table->primary(['class_id', 'equipment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_equipment');
        Schema::dropIfExists('equipment');
    }
};
