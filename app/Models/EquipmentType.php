<?php

namespace App\Models;

use App\Enums\EquipmentTypeEnum;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    protected $guarded = [];

    protected $casts = [
        'type' => EquipmentTypeEnum::class,
    ];
}
