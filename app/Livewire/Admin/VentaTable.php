<?php

namespace App\Livewire\Admin;

use App\Models\Sale;
use Livewire\Component;

class VentaTable extends Component
{
    public function render()
    {
        $sales = Sale::orderBy('created_at', 'desc')->paginate(10);;
        return view('livewire.admin.venta-table', compact('sales'));
    }
}
