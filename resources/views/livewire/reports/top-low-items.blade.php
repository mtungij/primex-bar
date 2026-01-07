<div class="p-4">

    <div class="mb-4">
        <label class="font-semibold">Select Date:</label>
        <input type="date" wire:model="date" class="border rounded p-2">
    </div>

    <div class="grid grid-cols-2 gap-4">

        {{-- Top Items --}}
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold mb-2">Top-Performing Items</h3>
            <table class="w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Product</th>
                        <th class="p-2 text-center">Qty Sold</th>
                        <th class="p-2 text-right">Sales Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topItems as $item)
                    <tr class="border-t">
                        <td class="p-2">{{ $item->product->name }}</td>
                        <td class="p-2 text-center">{{ $item->qty_sold }}</td>
                        <td class="p-2 text-right">{{ number_format($item->total_sales) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Low Items --}}
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-bold mb-2">Low-Performing Items</h3>
            <table class="w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Product</th>
                        <th class="p-2 text-center">Qty Sold</th>
                        <th class="p-2 text-right">Sales Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowItems as $item)
                    <tr class="border-t">
                        <td class="p-2">{{ $item->product->name }}</td>
                        <td class="p-2 text-center">{{ $item->qty_sold }}</td>
                        <td class="p-2 text-right">{{ number_format($item->total_sales) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>
