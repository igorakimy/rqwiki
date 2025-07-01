<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Position;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @method morphOne(string $class, string $string)
 */
trait HasPosition
{
    /**
     * Get the position on location map.
     *
     * @return MorphOne
     */
    public function position(): MorphOne
    {
        return $this->morphOne(Position::class, 'positionable');
    }
}
