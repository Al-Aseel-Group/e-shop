<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_url',
        'category_id',
        'qty',
        'price'
    ];


    protected $appends = [
        'is_active',
        'base'
    ];


    public function getIsActiveAttribute()
    {
        return $this->qty != 0;
    }

    public function getBaseAttribute()
    {
        return asset('storage/'.$this->image_url);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeGetActive()
    {
        return $this->where('qty','!=',0);
    }

}
