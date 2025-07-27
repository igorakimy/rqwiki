<?php

namespace App\Models;

use App\Enums\MonsterDefenceEnum;
use App\Enums\MonsterModeEnum;
use App\Traits\HasCategories;
use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Monster extends Model
{
    use HasImage, HasCategories, HasFactory;

    protected $guarded = [];

    protected $casts = [
        'defence' => MonsterDefenceEnum::class,
        'mode' => MonsterModeEnum::class,
        'xp_per_hp' => 'double'
    ];

    /**
     * Раса монстра.
     *
     * @return BelongsTo
     */
    public function race(): BelongsTo
    {
        return $this->belongsTo(Race::class);
    }

    /**
     * Стихийный элемент монстра.
     *
     * @return BelongsTo
     */
    public function element(): BelongsTo
    {
        return $this->belongsTo(Element::class);
    }

    /**
     * Локации, на которых обитает монстр.
     *
     * @return BelongsToMany
     */
    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'location_monsters');
    }

    /**
     * Большое изображение монстра.
     *
     * @return HasOne
     */
    public function bigImage(): HasOne
    {
        return $this->hasOne(Image::class, 'big_image_id', 'id');
    }
}
