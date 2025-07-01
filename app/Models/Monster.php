<?php

namespace App\Models;

use App\Enums\MonsterDefencesEnum;
use App\Enums\MonsterModesEnum;
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
        'defence' => MonsterDefencesEnum::class,
        'mode' => MonsterModesEnum::class,
    ];
}
