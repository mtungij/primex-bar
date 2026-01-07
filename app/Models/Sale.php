<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SaleItem;
use App\Models\Payment;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_method',
    ];

    /* Relationships */

    // Sale → User (Cashier)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Sale → Items
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Sale → Payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
