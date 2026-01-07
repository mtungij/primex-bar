<?php
namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class DailySales extends Component
{
    public $totalSales;
    public $totalTransactions;
    public $totalQuantity;
    public $productSales;

    public $cashiers = [];
public $selectedCashier = '';

   public function mount()
{
    $this->cashiers = User::orderBy('name')->get();
    $this->loadReport();
}


public function loadReport()
{
    $saleQuery = Sale::whereDate('created_at', today());

    if ($this->selectedCashier) {
        $saleQuery->where('user_id', $this->selectedCashier);
    }

    $this->totalSales = $saleQuery->sum('total_amount');
    $this->totalTransactions = $saleQuery->count();

    $this->totalQuantity = SaleItem::join('sales', 'sales.id', '=', 'sale_items.sale_id')
        ->whereDate('sales.created_at', today())
        ->when($this->selectedCashier, function ($q) {
            $q->where('sales.user_id', $this->selectedCashier);
        })
        ->sum('sale_items.qty');

    $this->productSales = SaleItem::join('sales', 'sales.id', '=', 'sale_items.sale_id')
        ->join('products', 'products.id', '=', 'sale_items.product_id')
        ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
        ->leftJoin('users', 'users.id', '=', 'sales.user_id')
        ->select(
            'products.name as product_name',
            'categories.name as category_name',
            'users.name as cashier',
            'sales.created_at as sold_at',
            DB::raw('SUM(sale_items.qty) as qty_sold'),
            DB::raw('SUM(sale_items.qty * sale_items.price) as total_amount')
        )
        ->whereDate('sales.created_at', today())
        ->when($this->selectedCashier, function ($q) {
            $q->where('sales.user_id', $this->selectedCashier);
        })
        ->groupBy(
            'products.id',
            'products.name',
            'categories.name',
            'users.name',
            'sales.created_at'
        )
        ->orderBy('sales.created_at', 'desc')
        ->get();
}

public function exportPdf()
{
    $rows = DB::table('sale_items')
        ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
        ->join('products', 'products.id', '=', 'sale_items.product_id')
        ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
        ->leftJoin('users', 'users.id', '=', 'sales.user_id')
        ->when($this->selectedCashier, function ($q) {
            $q->where('sales.user_id', $this->selectedCashier);
        })
        ->whereDate('sales.created_at', today())
        ->select(
            'products.name as product',
            'categories.name as category',
            'users.name as cashier',
            'sale_items.qty',
            'sale_items.price',
            DB::raw('(sale_items.qty * sale_items.price) as total'),
            'sales.created_at'
        )
        ->get();

   return Pdf::loadView('reports.sales-pdf', [
    'rows' => $rows,
    'date' => today()->format('Y-m-d')
])
->setPaper('a4', 'landscape')
->setOption('isHtml5ParserEnabled', true)
->setOption('isRemoteEnabled', true)
->setOption('defaultFont', 'DejaVu Sans') // important for UTF-8
->download('sales-report.pdf');
}


    public function render()
    {
        return view('livewire.reports.daily-sales');
    }
}

