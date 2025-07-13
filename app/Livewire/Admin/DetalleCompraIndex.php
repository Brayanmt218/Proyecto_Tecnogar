<?php

namespace App\Livewire\Admin;

use App\Models\Buy;
use App\Models\DetailBuy;
use App\Models\Product;
use Livewire\Component;

class DetalleCompraIndex extends Component
{
    public function render()
    {
        $buys = Buy::all();
        $products = Product::all();
        $detail_buys = DetailBuy::all();
        return view('livewire.admin.detalle-compra-index' , compact('buys','products', 'detail_buys'));
    }
}
