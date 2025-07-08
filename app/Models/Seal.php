<?php

namespace App\Models;

use App\Traits\HasBonuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Seal extends Model
{
    use HasBonuses;

    protected $guarded = [];

    /**
     * Get all equipment types that the seal may be stamped.
     *
     * @return BelongsToMany
     */
    public function equipmentTypes(): BelongsToMany
    {
        return $this->belongsToMany(
            EquipmentType::class,
            'seal_equipment_types'
        );
    }
}
