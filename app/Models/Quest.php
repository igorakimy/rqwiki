<?php

namespace App\Models;

use App\Traits\HasCategories;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Quest extends Model implements HasMedia
{
    use InteractsWithMedia, HasCategories;

    protected $guarded = [];
}
