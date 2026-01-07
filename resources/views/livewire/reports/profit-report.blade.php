<div class="p-4">

    <div class="mb-4">
        <label class="font-semibold">Select Date:</label>
        <input type="date" wire:model="date" class="border rounded p-2">
    </div>

    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Product</th>
                <th class="p-2 text-center">Qty Sold</th>
                <th class="p-2 text-right">Sales Amount</th>
                <th class="p-2 text-right">Cost</th>
                <th class="p-2 text-right">Profit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report as $row)
            <tr class="border-t">
                <td class="p-2">{{ $row['product_name'] }}</td>
                <td class="p-2 text-center">{{ $row['qty_sold'] }}</td>
                <td class="p-2 text-right">{{ number_format($row['total_sales']) }}</td>
                <td class="p-2 text-right">{{ number_format($row['cost']) }}</td>
                <td class="p-2 text-right font-bold">{{ number_format($row['profit']) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
