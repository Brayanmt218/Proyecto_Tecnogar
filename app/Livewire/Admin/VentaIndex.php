<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use App\Models\User;
use Livewire\Component;

class VentaIndex extends Component
{
    public function render()
    {
        $users = User::all();
        $customers = Customer::all();
        return view('livewire.admin.venta-index', compact('users', 'customers'));
    }
}
