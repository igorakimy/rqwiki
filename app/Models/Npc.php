<?php

namespace App\Models;

use App\Traits\HasCategories;
use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Npc extends Model
{
    use HasCategories, HasImage, HasFactory;

    protected $guarded = [];

    /**
     * Локации, на которых стоит НПС.
     *
     * @return BelongsToMany
     */
    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(
            Location::class,
            'location_npcs'
        )->orderBy('name');
    }

    /**
     * Группы НПС (инфанты, торговцы, квестовые, прочие)
     *
     * @return BelongsToMany
     */
    public function npc_groups(): BelongsToMany
    {
        return $this->belongsToMany(
            NpcGroup::class,
            'npc_npc_group'
        );
    }
}
