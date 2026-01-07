<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'buy_price',
        'sell_price',
        'stock_qty',
        'is_active',
    ];

    /* Relationships */

    // Product → Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Product → Sale Items
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Product → Stock Movements
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    /* Computed Stock (Best Practice) */
    public function getCurrentStockAttribute()
    {
        $in  = $this->stockMovements()->where('type', 'in')->sum('qty');
        $out = $this->stockMovements()->where('type', 'out')->sum('qty');

        return $in - $out;
    }
}
