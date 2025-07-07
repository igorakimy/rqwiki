<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @method belongsTo(string $class)
 */
trait HasEquipmentType
{
    /**
     * @return mixed
     */
    public function equipmentType(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class);
    }
}
