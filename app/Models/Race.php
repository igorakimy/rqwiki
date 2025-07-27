<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasImage;

    protected $guarded = [];
}
