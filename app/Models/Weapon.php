<?php

namespace App\Models;

use App\Traits\HasEquipmentType;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Weapon extends Model implements HasMedia
{
    use InteractsWithMedia, HasEquipmentType;

    protected $guarded = [];
}
