<?php

namespace App\Models;

use App\Enums\EquipmentItemClassEnum;
use App\Enums\GenderEnum;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'item_class' => EquipmentItemClassEnum::class,
        'gender' => GenderEnum::class,
    ];
}
