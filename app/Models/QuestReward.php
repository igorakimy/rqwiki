<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class QuestReward extends Model
{
    protected $guarded = [];

    /**
     * Get the parent rewardable models.
     *
     * @return MorphTo
     */
    public function rewardable(): MorphTo
    {
        return $this->morphTo();
    }
}
