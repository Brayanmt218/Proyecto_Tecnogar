<?php

namespace App\Livewire\Admin;

use App\Models\Buy;
use App\Models\Provider;
use Livewire\Component;

class CompraIndex extends Component
{
    public function render()
    {
        $buys = Buy::all();
        $providers = Provider::all();
        return view('livewire.admin.compra-index' , compact('providers','buys'));
    }
}
