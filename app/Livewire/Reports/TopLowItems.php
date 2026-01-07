<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class TopLowItems extends Component
{
    public $date;
    public $topCount = 5; // number of top/low items to show

    public function mount()
    {
        $this->date = now()->format('Y-m-d'); // default to today
    }

    public function render()
    {
        // Group by product and sum qty sold
        $items = SaleItem::join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->select(
                'sale_items.product_id',
                DB::raw('SUM(sale_items.qty) as qty_sold'),
                DB::raw('SUM(sale_items.qty * sale_items.price) as total_sales')
            )
            ->whereDate('sales.created_at', $this->date)
            ->groupBy('sale_items.product_id')
            ->with('product:id,name')
            ->get();

        // Top-performing items
        $topItems = $items->sortByDesc('qty_sold')->take($this->topCount);

        // Low-performing items (sold at least 1)
        $lowItems = $items->sortBy('qty_sold')->take($this->topCount);

        return view('livewire.reports.top-low-items', [
            'topItems' => $topItems,
            'lowItems' => $lowItems,
        ]);
    }
}
