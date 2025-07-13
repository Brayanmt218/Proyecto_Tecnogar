<?php

namespace App\Livewire\Admin;

use App\Models\Buy;
use App\Models\DetailBuy;
use App\Models\Product;
use Livewire\Component;

class DetalleCompraTable extends Component
{
    public function render()
    {
        $detail_buys = DetailBuy::orderBy('created_at', 'desc')
            ->paginate(10);
        $products = Product::all();
        $buys = Buy::all();
        return view('livewire.admin.detalle-compra-table', compact('detail_buys','products','buys'));
    }
}
