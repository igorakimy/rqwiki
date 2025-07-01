<?php

namespace App\Models;

use App\Traits\HasCategories;
use App\Traits\HasPosition;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasPosition, HasCategories;

    protected $guarded = [];
}
