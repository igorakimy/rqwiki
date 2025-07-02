<?php

namespace App\Models;

use App\Traits\HasCategories;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Npc extends Model implements HasMedia
{
    use InteractsWithMedia,
        HasCategories;

    protected $guarded = [];
}
