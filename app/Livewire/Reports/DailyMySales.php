<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DailyMySales extends Component
{
    public $totalSales = 0;
    public $totalTransactions = 0;
    public $totalQuantity = 0;
    public $productSales = [];

    public function mount()
    {
        $this->loadReport();
    }

    public function loadReport()
    {
        $userId = Auth::id(); // only my sales

        // Total sales today by me
        $this->totalSales = Sale::whereDate('created_at', today())
            ->where('user_id', $userId)
            ->sum('total_amount');

        $this->totalTransactions = Sale::whereDate('created_at', today())
            ->where('user_id', $userId)
            ->count();

        $this->totalQuantity = SaleItem::join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->whereDate('sales.created_at', today())
            ->where('sales.user_id', $userId)
            ->sum('qty');

        // Products sold today by me
        $this->productSales = SaleItem::join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->whereDate('sales.created_at', today())
            ->where('sales.user_id', $userId)
            ->select(
                'products.name as product',
                'categories.name as category',
                DB::raw('SUM(sale_items.qty) as qty_sold'),
                DB::raw('SUM(sale_items.qty * sale_items.price) as total_amount')
            )
            ->groupBy('products.id', 'categories.id', 'products.name', 'categories.name')
            ->get();
    }

    public function render()
    {
        return view('livewire.reports.daily-my-sales');
    }
}
