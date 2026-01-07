<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class AddProduct extends Component
{
    public $name;
    public $category_id;
    public $buy_price = 0;
    public $sell_price = 0;
    public $stock_qty = 0;
  

    public $categories = [];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function addProduct()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'stock_qty' => 'required|integer|min:0',
           
        ]);

       

        Product::create($validatedData);

        $this->reset(['name','category_id','buy_price','sell_price','stock_qty']);

        session()->flash('success', 'Product imeongezwa kikamilifu');
    }

    public function render()
    {
        return view('livewire.product.add-product');
    }
}
