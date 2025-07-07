<?php

namespace App\Models;

use App\Enums\EquipmentItemClassEnum;
use App\Enums\GenderEnum;
use App\Traits\HasEquipmentType;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasEquipmentType;

    protected $guarded = [];

    protected $casts = [
        'item_class' => EquipmentItemClassEnum::class,
        'gender' => GenderEnum::class,
    ];
}
