<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LocationType extends Model
{
    protected $guarded = [];

    /**
     * Локации, которые принадлежат данному типу локаций.
     *
     * @return BelongsToMany
     */
    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(
            Location::class,
            'location_location_type',
        );
    }
}
