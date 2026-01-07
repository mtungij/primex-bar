<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Product;

class OutOfStock extends Component
{
    public $products = [];
    public $threshold = 0; // optional, change to alert for low stock

    public function mount()
    {
        $this->loadReport();
    }

    public function loadReport()
    {
        // Load products whose current_stock <= threshold
        $this->products = Product::with('category')
            ->get()
            ->filter(fn($p) => $p->current_stock <= $this->threshold)
            ->sortBy('name');
    }

    public function render()
    {
        return view('livewire.reports.out-of-stock');
    }
}
