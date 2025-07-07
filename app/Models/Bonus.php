<?php

namespace App\Models;

use App\Enums\BonusesValueTypeEnum;
use Database\Factories\BonusFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    /** @use HasFactory<BonusFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'value_type' => BonusesValueTypeEnum::class,
    ];
}
