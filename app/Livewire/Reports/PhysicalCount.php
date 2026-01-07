<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Product;

class PhysicalCount extends Component
{
    public $products;
    public $counts = []; // physical counts from user input
    public $date;

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $this->products = Product::with('category')->get();
    }

    public function updatedCounts($value, $key)
    {
        // Ensure numeric value
        $this->counts[$key] = max(0, (int) $value);
    }

    public function render()
    {
        return view('livewire.reports.physical-count', [
            'products' => $this->products,
        ]);
    }
}
