<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
    ];

    /* Relationships */

    // Category → Products
    public function products()
    {
        return $this->hasMany(Product::class);
    }


    

    // Self relationship (parent)
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Self relationship (children)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}

