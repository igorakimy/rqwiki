<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Card extends Model
{
    protected $guarded = [];

    /**
     * Get all types of equipment where the card can be inserted.
     *
     * @return BelongsToMany
     */
    public function equipmentTypes(): BelongsToMany
    {
        return $this->belongsToMany(
            EquipmentType::class,
            'card_equipment_types'
        );
    }
}
