<?php

namespace App\Models;

use App\Enums\EquipmentTypesEnum;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    protected $guarded = [];

    protected $casts = [
        'type' => EquipmentTypesEnum::class,
    ];
}
