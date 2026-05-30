<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'group', 'sort_order', 'image'];

    public const GROUP_TIRES = 'shiny';

    public const GROUP_WHEELS = 'diski';

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
