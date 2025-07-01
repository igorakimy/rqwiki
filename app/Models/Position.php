<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Position extends Model
{
    protected $guarded = [];

    /**
     * Get the parent positionable model (location, npc or machines)
     *
     * @return MorphTo
     */
    public function positionable(): MorphTo
    {
        return $this->morphTo();
    }
}
