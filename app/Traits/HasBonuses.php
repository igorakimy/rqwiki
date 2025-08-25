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
        return $this->morphToMany(Bonus::class, 'bonusable')
            ->orderByPivot('order')
            ->withPivot([
                'bonus_id',
                'value',
                'value_type',
                'duration',
                'use_alt_name',
                'special_property',
                'order'
            ]);
    }
}
