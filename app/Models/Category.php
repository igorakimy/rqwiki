<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all the locations that are assigned this category.
     *
     * @return MorphToMany
     */
    public function locations(): MorphToMany
    {
        return $this->morphedByMany(Location::class, 'categoriable');
    }
}
