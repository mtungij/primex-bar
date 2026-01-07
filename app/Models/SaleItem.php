<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'sale_id',
        'product_id',
        'qty',
        'price',
    ];

    /* Relationships */

    // Sale Item → Sale
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Sale Item → Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

