<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    use HasImage;

    protected $guarded = [];
}
