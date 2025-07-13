<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\Provider;
use Livewire\Component;

class ProductoIndex extends Component
{
    public function render()
    {
        $products = Product::all();
        $categories = Category::all();
        $providers = Provider::all();
        return view('livewire.admin.producto-index', compact('categories', 'providers', 'products'));
    }
}
