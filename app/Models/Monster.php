<?php

namespace App\Models;

use App\Enums\MonsterDefenceEnum;
use App\Enums\MonsterModeEnum;
use App\Traits\HasCategories;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Monster extends Model implements HasMedia
{
    use InteractsWithMedia,
        HasCategories;

    protected $guarded = [];

    protected $casts = [
        'defence' => MonsterDefenceEnum::class,
        'mode' => MonsterModeEnum::class,
    ];
}
