<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;

class CharacterClass extends Model
{
    use HasImage;

    protected $table = 'classes';

    protected $guarded = [];
}
