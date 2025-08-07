<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;

class QuestType extends Model
{
    use HasImage;

    protected $guarded = [];
}
