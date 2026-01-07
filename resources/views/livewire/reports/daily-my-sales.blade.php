<div>

    <div class="grid grid-cols-3 gap-4 mb-4">
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">Total Sales</div>
            <div class="text-xl font-bold">{{ number_format($totalSales) }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">Transactions</div>
            <div class="text-xl font-bold">{{ $totalTransactions }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">Items Sold</div>
            <div class="text-xl font-bold">{{ $totalQuantity }}</div>
        </div>
    </div>

    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Product</th>
                <th class="p-2 text-left">Category</th>
                <th class="p-2 text-center">Qty Sold</th>
                <th class="p-2 text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productSales as $row)
                <tr class="border-t">
                    <td class="p-2">{{ $row->product }}</td>
                    <td class="p-2">{{ $row->category }}</td>
                    <td class="p-2 text-center">{{ $row->qty_sold }}</td>
                    <td class="p-2 text-right">{{ number_format($row->total_amount) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-2 text-center">No sales today</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
