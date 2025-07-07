<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Bonus;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @method morphToMany(string $class, string $string)
 */
trait HasBonuses
{
    /**
     * Get all the bonuses for the entity.
     *
     * @return MorphToMany
     */
    public function bonuses(): MorphToMany
    {
        return $this->morphToMany(Bonus::class, 'bonusable');
    }
}
