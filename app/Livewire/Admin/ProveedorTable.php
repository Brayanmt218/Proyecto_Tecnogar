<?php

namespace App\Livewire\Admin;

use App\Models\Provider;
use Livewire\Component;

class ProveedorTable extends Component
{
    public function render()
    {
        $providers = Provider::where('status', 1)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
       return view('livewire.admin.proveedor-table', compact('providers'));
    }
}
