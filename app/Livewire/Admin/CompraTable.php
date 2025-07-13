<?php

namespace App\Livewire\Admin;

use App\Models\Buy;
use App\Models\Provider;
use Livewire\Component;

class CompraTable extends Component
{
    public function render()
    {
        $buys = Buy::orderBy('created_at', 'desc')
            ->paginate(10);
        $providers = Provider::all();
        return view('livewire.admin.compra-table', compact('buys', 'providers'));
    }
}
