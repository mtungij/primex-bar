<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class DailyStockReport extends Component
{
    public $reportData = [];
    public $reportDate;
    public $totals = [
        'opening_stock' => 0,
        'added_stock' => 0,
        'sold_qty' => 0,
        'closing_stock' => 0,
        'buy_value' => 0,
        'sell_value' => 0,
        'profit' => 0,
    ];

    public function mount()
    {
        $this->reportDate = today()->format('Y-m-d');
        $this->loadReport();
    }

    public function loadReport()
    {
        $date = $this->reportDate;
        $yesterday = date('Y-m-d', strtotime($date . ' -1 day'));

        // Get all products
        $products = Product::with('category')->get();

        $this->reportData = [];
        $totals = [
            'opening_stock' => 0,
            'added_stock' => 0,
            'sold_qty' => 0,
            'closing_stock' => 0,
            'buy_value' => 0,
            'sell_value' => 0,
            'profit' => 0,
        ];

        foreach ($products as $index => $product) {
            // Opening stock (stock at beginning of the day - yesterday's closing)
            $openingStock = $this->getStockAtDate($product->id, $yesterday);

            // Added stock (stock IN today)
            $addedStock = StockMovement::where('product_id', $product->id)
                ->where('type', 'in')
                ->whereDate('created_at', $date)
                ->sum('qty');

            // Sold today
            $soldToday = SaleItem::join('sales', 'sales.id', '=', 'sale_items.sale_id')
                ->where('sale_items.product_id', $product->id)
                ->whereDate('sales.created_at', $date)
                ->sum('sale_items.qty');

            // Closing stock (current stock_qty)
            $closingStock = $product->stock_qty;

            // Calculate values
            $buyValue = $soldToday * $product->buy_price;
            $sellValue = $soldToday * $product->sell_price;
            $profit = $sellValue - $buyValue;

            $this->reportData[] = [
                'sn' => $index + 1,
                'product_name' => $product->name,
                'category' => $product->category->name ?? 'N/A',
                'opening_stock' => $openingStock,
                'added_stock' => $addedStock,
                'buy_price' => $product->buy_price,
                'sell_price' => $product->sell_price,
                'sold_today' => $soldToday,
                'closing_stock' => $closingStock,
                'buy_value' => $buyValue,
                'sell_value' => $sellValue,
                'profit' => $profit,
            ];

            // Update totals
            $totals['opening_stock'] += $openingStock;
            $totals['added_stock'] += $addedStock;
            $totals['sold_qty'] += $soldToday;
            $totals['closing_stock'] += $closingStock;
            $totals['buy_value'] += $buyValue;
            $totals['sell_value'] += $sellValue;
            $totals['profit'] += $profit;
        }

        $this->totals = $totals;
    }

    private function getStockAtDate($productId, $date)
    {
        $product = Product::find($productId);
        $currentStock = $product->stock_qty;

        // Get stock changes after the date
        $stockIn = StockMovement::where('product_id', $productId)
            ->where('type', 'in')
            ->where('created_at', '>', $date . ' 23:59:59')
            ->sum('qty');

        $stockOut = StockMovement::where('product_id', $productId)
            ->where('type', 'out')
            ->where('created_at', '>', $date . ' 23:59:59')
            ->sum('qty');

        $soldAfter = SaleItem::join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->where('sale_items.product_id', $productId)
            ->where('sales.created_at', '>', $date . ' 23:59:59')
            ->sum('sale_items.qty');

        // Calculate stock at that date
        $stockAtDate = $currentStock - $stockIn + $stockOut + $soldAfter;

        return max(0, $stockAtDate);
    }

    public function exportPdf()
    {
        return Pdf::loadView('reports.daily-stock-pdf', [
            'reportData' => $this->reportData,
            'totals' => $this->totals,
            'reportDate' => $this->reportDate,
        ])
        ->setPaper('a4', 'landscape')
        ->download('daily-stock-report-' . $this->reportDate . '.pdf');
    }

    public function render()
    {
        return view('livewire.reports.daily-stock-report')
            ->layout('components.layouts.app', ['title' => 'Daily Stock Report']);
    }
}
