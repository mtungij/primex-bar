<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'use_discount',
        // unaweza kuongeza fields nyingine kama store_name, tax, currency, etc
    ];

    public $timestamps = false; // optional, kama huna created_at/updated_at
}
