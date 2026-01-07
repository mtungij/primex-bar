<?php

namespace App\Livewire\Stock;

use Livewire\Component;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;

class Out extends Component
{
    public $products;
    public $selectedProduct = null;
    public $qty = 1;
    public $reason = 'damage';

    public function mount()
    {
        if (!in_array(auth()->user()->role, ['admin','manager'])) {
            abort(403, 'You do not have permission to access this page.');
        }

        $this->products = Product::where('is_active', true)->get();
    }

    public function removeStock()
    {
        $this->validate([
            'selectedProduct' => 'required|exists:products,id',
            'qty' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail($this->selectedProduct);

        if ($this->qty > $product->current_stock) {
            session()->flash('error', 'Huna stock ya kutosha');
            return;
        }

        StockMovement::create([
            'product_id' => $this->selectedProduct,
            'qty' => $this->qty,
            'type' => 'out',
            'reason' => $this->reason,
            'user_id' => Auth::id(),
        ]);

        $this->reset(['selectedProduct','qty']);
        session()->flash('success', 'Stock imepunguzwa kwa bidhaa hii');
    }

    public function render()
    {
        return view('livewire.stock.out');
    }
}
