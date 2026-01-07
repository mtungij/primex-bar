<div>


    <div class="mb-4 flex items-center gap-3">
    <label class="font-semibold">Cashier:</label>

    <select wire:model="selectedCashier"
            wire:change="loadReport"
            class="border rounded px-3 py-1">
        <option value="">All Cashiers</option>
        @foreach($cashiers as $cashier)
            <option value="{{ $cashier->id }}">
                {{ $cashier->name }}
            </option>
        @endforeach
    </select>
</div>

{{-- <button wire:click="exportPdf"
    class="bg-red-600 text-white px-4 py-2 rounded">
    Export PDF
</button> --}}


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
            <th class="p-2 text-left">Cashier</th>
            <th class="p-2 text-center">Time</th>
            <th class="p-2 text-center">Qty Sold</th>
            <th class="p-2 text-right">Amount</th>
        </tr>
    </thead>
    <tbody>
        @forelse($productSales as $row)
            <tr class="border-t">
                <td class="p-2">{{ $row->product_name }}</td>
                <td class="p-2">{{ $row->category_name ?? 'N/A' }}</td>
                <td class="p-2">{{ $row->cashier }}</td>
                <td class="p-2 text-center">
                    {{ \Carbon\Carbon::parse($row->sold_at)->format('H:i') }}
                </td>
                <td class="p-2 text-center">{{ $row->qty_sold }}</td>
                <td class="p-2 text-right">
                    {{ number_format($row->total_amount) }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="p-4 text-center text-gray-500">
                    No sales recorded today
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</div>