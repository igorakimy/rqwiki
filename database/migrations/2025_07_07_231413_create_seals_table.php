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
        Schema::create('seals', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('seal_equipment_types', function (Blueprint $table) {
            $table->foreignId('seal_id')
                ->constrained('seals')
                ->cascadeOnDelete();

            $table->foreignId('equipment_type_id')
                ->constrained('equipment_types')
                ->cascadeOnDelete();

            $table->primary(['seal_id', 'equipment_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seal_equipment_types');
        Schema::dropIfExists('seals');
    }
};
