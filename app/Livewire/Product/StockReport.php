<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class StockReport extends Component
{

    public $products = [];

    public $categories = [];
    public $search = '';
    public $selectedCategory = '';

     public function mount()
    {
        $this->categories = Category::all();
        $this->loadProducts();
    }

      public function updatedSearch()
    {
        $this->loadProducts();
    }

    public function updatedSelectedCategory()
    {
        $this->loadProducts();
    }
  public function loadProducts()
    {
        $query = Product::with('category');

   

        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $this->products = $query->get()->map(function ($product) {
            $product->profit_per_unit = $product->selling_price - $product->buying_price;
            $product->total_profit = $product->profit_per_unit * $product->stock_qty;
            return $product;
        });
    }

    public function render()
    {
        return view('livewire.product.stock-report');
    }
}
