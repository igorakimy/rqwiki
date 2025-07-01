<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @method morphToMany(string $class, string $string)
 */
trait HasCategories
{
    /**
     * Get all the categories for the entity.
     *
     * @return MorphToMany
     */
    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categoriable');
    }
}
