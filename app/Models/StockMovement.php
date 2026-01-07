<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'qty',
        'type',       // 'in' or 'out'
        'reason',     // 'purchase', 'adjustment', 'sale'
        'user_id',
        'buy_price',  // optional, for 'in' stock
        'sell_price', // optional, for 'in' stock
    ];

    /* Relationships */

    // Stock Movement → Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Stock Movement → User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* Profit calculation helper (optional) */
    public function getProfitAttribute()
    {
        if($this->type === 'out' && $this->buy_price && $this->sell_price) {
            return ($this->sell_price - $this->buy_price) * $this->qty;
        }
        return 0;
    }
}
