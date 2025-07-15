<?php

use App\Enums\ImageTypeEnum;
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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ImageTypeEnum::values())
                ->default(ImageTypeEnum::IMAGE->value);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('imageables', function (Blueprint $table) {
            $table->foreignId('image_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('imageable_id');
            $table->string('imageable_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imageables');
        Schema::dropIfExists('images');
    }
};
