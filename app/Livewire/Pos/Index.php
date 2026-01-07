<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $categories;
    public $selectedCategory = null;
    public $products = [];

    public $search = '';


    public $cart = [];
    public $paymentMethod = 'cash';
    public $lastSale = null;
    public $useDiscount = true;

   public function mount()
{
    // Load parent categories + children + products count
    $this->categories = Category::whereNull('parent_id')
        ->with(['children' => function($q) {
            $q->withCount('products');
        }])
        ->get();

    $setting = Setting::first();
    $this->useDiscount = $setting ? $setting->use_discount : true;

    $this->loadProducts();
}


public function highlight($text)
{
    if (!$this->search) {
        return e($text);
    }

    return preg_replace(
        '/(' . preg_quote($this->search, '/') . ')/i',
        '<span class="bg-yellow-200 font-bold">$1</span>',
        e($text)
    );
}



public function selectCategory($categoryId)
{
    $this->selectedCategory = $categoryId;
    $this->search = ''; // reset search when switching category
    $this->loadProducts();
}

public function updatedSearch()
{
    $this->loadProducts();
}

protected function loadProducts()
{
    $query = Product::where('is_active', true);

    if($this->selectedCategory) {
        $query->where('category_id', $this->selectedCategory);
    }

    if($this->search) {
        $query->where('name', 'like', '%'.$this->search.'%');
    }

    $this->products = $query->get();
}



    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->current_stock < 1) {
            session()->flash('error', 'Stock imeisha');
            return;
        }

        if (!isset($this->cart[$productId])) {
            $this->cart[$productId] = [
                'name' => $product->name,
                'price' => $product->sell_price,
                'qty' => 1,
                'discount' => 0,
                'discount_type' => 'amount',
            ];
        } else {
            $this->cart[$productId]['qty'] += 1;
        }
    }

    public function removeFromCart($productId)
    {
        unset($this->cart[$productId]);
    }

    public function updateQty($productId, $qty)
    {
        $product = Product::findOrFail($productId);
        $availableStock = $product->current_stock;

        if ($qty <= 0) {
            unset($this->cart[$productId]);
            return;
        }

        if ($qty > $availableStock) {
            $this->cart[$productId]['qty'] = $availableStock;
            session()->flash('error', "Stock iliyopo ni {$availableStock} tu");
            return;
        }

        $this->cart[$productId]['qty'] = $qty;
    }

    public function updateDiscount($productId, $value, $type = 'amount')
    {
        if (!$this->useDiscount) return;
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['discount'] = max(0, $value);
            $this->cart[$productId]['discount_type'] = $type;
        }
    }

    public function getCartTotalProperty()
    {
        return collect($this->cart)->sum(function($item) {
            $subtotal = $item['price'] * $item['qty'];
            if ($this->useDiscount) {
                if ($item['discount_type'] === 'amount') {
                    $subtotal -= $item['discount'];
                } else {
                    $subtotal -= ($subtotal * $item['discount'] / 100);
                }
            }
            return $subtotal;
        });
    }

public function checkout()
{
    if (empty($this->cart)) {
        session()->flash('error', 'Cart is empty');
        return;
    }

    try {
        DB::transaction(function () {
            // Validate stock for all items first
            foreach ($this->cart as $productId => $item) {
                $product = Product::findOrFail($productId);
                if ($item['qty'] > $product->current_stock) {
                    throw new \Exception("Stock ya {$product->name} haitoshi");
                }
            }

            // Calculate total discount
            $totalDiscount = 0;
            if ($this->useDiscount) {
                foreach ($this->cart as $item) {
                    $totalDiscount += $item['discount'] ?? 0;
                }
            }

            // Create sale
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'total_amount' => $this->cartTotal,
                'payment_method' => $this->paymentMethod,
            ]);

            // Create sale items and update stock
            foreach ($this->cart as $productId => $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $productId,
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                ]);

                StockMovement::create([
                    'product_id' => $productId,
                    'qty' => $item['qty'],
                    'type' => 'out',
                    'reason' => 'sale',
                    'user_id' => Auth::id(),
                ]);
            }

            $this->lastSale = $sale;
        });

        // Reset cart & payment after successful transaction
        $this->cart = [];
        $this->paymentMethod = 'cash';
        
        session()->flash('success', 'Sale completed successfully!');
        
    } catch (\Exception $e) {
        session()->flash('error', $e->getMessage());
    }
}


    public function render()
    {
        return view('livewire.pos.index');
    }
}
