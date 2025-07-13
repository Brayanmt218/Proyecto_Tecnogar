<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\Provider;
use Livewire\Component;

class ProductoTable extends Component
{
    public function render()
    {
        $providers= Provider::all();
        $categories = Category::all();
        $products = Product::where('status', 1)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('livewire.admin.producto-table' , compact('products','categories','providers'));
    }
}
