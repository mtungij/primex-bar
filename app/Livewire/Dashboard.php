<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $todaySales;
    public $todayProfit;
    public $totalProducts;
    public $totalOrders;
    public $soldToday;
    public $remainingStock;
    public $topSellingProducts;
    public $lowStockProducts;
    public $salesGrowth;
    public $salesByCategory;
    public $categoryLabels;
    public $categorySales;



    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        // Today's total sales amount
        $this->todaySales = Sale::whereDate('created_at', today())->sum('total_amount');

        // Calculate today's profit
        $todaySalesItems = SaleItem::join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->whereDate('sales.created_at', today())
            ->select(
                'sale_items.qty',
                'sale_items.price as sell_price',
                'products.buy_price'
            )
            ->get();

        $this->todayProfit = $todaySalesItems->sum(function($item) {
            return ($item->sell_price - $item->buy_price) * $item->qty;
        });

        // Total products
        $this->totalProducts = Product::count();

        // Total orders today
        $this->totalOrders = Sale::whereDate('created_at', today())->count();

        // Total quantity sold today
        $this->soldToday = SaleItem::join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->whereDate('sales.created_at', today())
            ->sum('sale_items.qty');


        // Remaining stock (total current stock quantity)
        $this->remainingStock = SaleItem::sum('qty');
// dd($this->remainingStock);
       

        // Top 5 selling products today
        $this->topSellingProducts = SaleItem::join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->whereDate('sales.created_at', today())
            ->select(
                'products.name',
                DB::raw('SUM(sale_items.qty) as total_sold')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Low stock products (stock_qty <= 10)
        $this->lowStockProducts = Product::where('stock_qty', '<=', 10)
            ->where('is_active', true)
            ->orderBy('stock_qty', 'asc')
            ->limit(5)
            ->get();

        // Sales growth (compare with yesterday)
        $yesterdaySales = Sale::whereDate('created_at', today()->subDay())->sum('total_amount');
        if ($yesterdaySales > 0) {
            $this->salesGrowth = (($this->todaySales - $yesterdaySales) / $yesterdaySales) * 100;
        } else {
            $this->salesGrowth = $this->todaySales > 0 ? 100 : 0;
        }

        // Sales by category (for chart)
        $this->salesByCategory = SaleItem::join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->whereDate('sales.created_at', today())
            ->select(
                'categories.name as category_name',
                DB::raw('SUM(sale_items.qty * sale_items.price) as total_sales')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_sales')
            ->get();

        $this->categoryLabels = $this->salesByCategory->pluck('category_name')->toJson();
        $this->categorySales = $this->salesByCategory->pluck('total_sales')->toJson();
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('components.layouts.app', ['title' => 'Dashboard']);
    }
}
