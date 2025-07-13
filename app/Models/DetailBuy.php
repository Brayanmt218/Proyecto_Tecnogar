<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBuy extends Model
{
    use HasFactory;
    protected $fillable = [
        'buy_id',
        'product_id',
        'stock',
        'price_unit'
    ];

    //relacion con usuario
    public function buy()
    {
        return $this->belongsTo(Buy::class, 'buy_id');
    }
    //relacion con proveedor
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
