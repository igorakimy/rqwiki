<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\QuestCondition;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @method morphMany(string $class, string $string)
 */
trait HasInQuestConditions
{
    public function quest_conditions(): MorphMany
    {
        return $this->morphMany(QuestCondition::class, 'conditionable');
    }
}
