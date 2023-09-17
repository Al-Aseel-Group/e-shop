<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'qty'
    ];

    protected $appends = [
        'total'
    ];

    public function getTotalAttribute()
    {
        return $this->qty * $this->product->price;
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
