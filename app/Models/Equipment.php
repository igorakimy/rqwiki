<?php

namespace App\Models;

use App\Enums\EquipmentItemClassEnum;
use App\Enums\GenderEnum;
use App\Traits\HasBonuses;
use App\Traits\HasCategories;
use App\Traits\HasEquipmentType;
use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{
    use HasFactory,
        HasEquipmentType,
        HasImage,
        HasBonuses,
        HasCategories;

    protected $guarded = [];

    protected $casts = [
        'item_class' => EquipmentItemClassEnum::class,
        'gender' => GenderEnum::class,
    ];

    /**
     * Классы персонажей, которые могут экипировать предмет экипировки.
     *
     * @return BelongsToMany
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(
            CharacterClass::class,
            'class_equipment',
            'equipment_id',
            'class_id',
        )->orderBy('name');
    }
}
