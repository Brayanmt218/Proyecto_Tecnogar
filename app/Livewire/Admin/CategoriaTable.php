<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;

class Categoriatable extends Component
{
    public function render()
    {
        $categories = Category::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.admin.categoria-table', compact('categories'));
    }
}