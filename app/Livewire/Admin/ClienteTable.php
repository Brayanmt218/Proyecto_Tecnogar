<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use Livewire\Component;

class ClienteTable extends Component
{
    public function render()
    {
        $customers = Customer::orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.admin.cliente-table' , compact('customers'));
    }
}
