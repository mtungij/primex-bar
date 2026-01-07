<?php

namespace App\Livewire\Stock;

use Livewire\Component;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;

class In extends Component
{
    public $products;
    public $selectedProduct = null;
    public $qty = 1;
    public $reason = 'purchase';

    public $buyPrice;
public $sellPrice;


    public function mount()
    {
        $this->products = Product::where('is_active', true)->get();
    }

  public function addStock()
{
    $this->validate([
        'selectedProduct' => 'required|exists:products,id',
        'qty' => 'required|numeric|min:1',
        'buyPrice' => 'required|numeric|min:0',
        'sellPrice' => 'required|numeric|min:0',
    ]);

    $product = Product::find($this->selectedProduct);

    // Create stock movement
    StockMovement::create([
        'product_id' => $product->id,
        'qty' => $this->qty,
        'type' => 'in',
        'reason' => $this->reason,
        'user_id' => Auth::id(),
        'buy_price' => $this->buyPrice,
        'sell_price' => $this->sellPrice,
    ]);

    // Optional: update product sell price globally
    $product->update([
        'sell_price' => $this->sellPrice,
    ]);

    $this->reset(['selectedProduct', 'qty', 'buyPrice', 'sellPrice']);
    session()->flash('success', 'Stock imeongezwa kwa bidhaa hii');
}


    public function render()
    {
        return view('livewire.stock.in');
    }
}
