<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'category_id',
        'provider_id',
        'name',
        'description',
        'nro_serie',
        'precio_venta',
        'precio_compra',
        'stock',
        'stock_minimo',
        'status'
    ];

    protected $casts=[
        'status'=>'boolean'
    ];

    //Relacion con categoria
    public function Category(){
        return $this->belongsTo(Category::class , 'category_id');
    }
    //Relacion con Proveedor
    public function Provider(){
        return $this->belongsTo(Provider::class , 'provider_id');
    }
}
