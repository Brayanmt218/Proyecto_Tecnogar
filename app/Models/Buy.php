<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'provider_id',
        'date',
        'total',
        'voucher_type'
    ];

    //relacion con usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    //relacion con proveedor
    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
}
