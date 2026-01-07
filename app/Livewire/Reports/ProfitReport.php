<?php


namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\SaleItem;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class ProfitReport extends Component
{
    public $date;

    public function mount()
    {
        $this->date = now()->format('Y-m-d'); // default today
    }

    public function render()
    {
        $items = SaleItem::with('product')
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->select(
                'sale_items.product_id',
                DB::raw('SUM(sale_items.qty) as qty_sold'),
                DB::raw('SUM(sale_items.qty * sale_items.price) as total_sales')
            )
            ->whereDate('sales.created_at', $this->date)
            ->groupBy('sale_items.product_id')
            ->get();

        $report = $items->map(function ($item) {
            $avgBuyPrice = StockMovement::where('product_id', $item->product_id)
                ->where('type', 'in')
                ->avg('buy_price');

            $cost = $avgBuyPrice * $item->qty_sold;
            $profit = $item->total_sales - $cost;

            return [
                'product_name' => $item->product->name,
                'qty_sold' => $item->qty_sold,
                'total_sales' => $item->total_sales,
                'cost' => $cost,
                'profit' => $profit,
            ];
        });

        return view('livewire.reports.profit-report', [
            'report' => $report,
        ]);
    }
}
