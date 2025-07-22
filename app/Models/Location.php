<?php

namespace App\Models;

use App\Traits\HasCategories;
use App\Traits\HasImage;
use App\Traits\HasPosition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Location extends Model
{
    use HasImage, HasPosition, HasCategories;

    protected $guarded = [];

    /**
     * Типы локаций.
     *
     * @return BelongsToMany
     */
    public function location_types(): BelongsToMany
    {
        return $this->belongsToMany(
            LocationType::class,
            'location_location_type'
        );
    }
}
