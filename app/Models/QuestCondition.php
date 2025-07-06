<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class QuestCondition extends Model
{
    protected $guarded = [];

    /**
     * Get the parent conditionable model.
     *
     * @return MorphTo
     */
    public function conditionable(): MorphTo
    {
        return $this->morphTo();
    }
}
