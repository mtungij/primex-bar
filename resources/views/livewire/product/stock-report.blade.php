<div class="p-4">

    <h2 class="text-xl font-bold mb-4">Stock Report</h2>

    {{-- Filters --}}
    <div class="flex gap-4 mb-4">
        <input type="text" wire:model="search" placeholder="Search product..."
               class="border rounded p-2 flex-1">

        <select wire:model="selectedCategory" class="border rounded p-2">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">S/N</th>
                <th class="p-2 border">Product</th>
                <th class="p-2 border">Category</th>
                <th class="p-2 border text-right">Stock Qty</th>
                <th class="p-2 border text-right">Buying Price</th>
                <th class="p-2 border text-right">Selling Price</th>
                <th class="p-2 border text-right">Profit/Unit</th>
                <th class="p-2 border text-right">Total Potential Profit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr class="border-t">
                <td class="p-2 border text-center">{{ $index + 1 }}</td>
                <td class="p-2 border">{{ $product->name }}</td>
                <td class="p-2 border">{{ $product->category->name ?? '-' }}</td>
                <td class="p-2 border text-right">{{ $product->stock_qty }}</td>
                <td class="p-2 border text-right">{{ number_format($product->buying_price) }}</td>
                <td class="p-2 border text-right">{{ number_format($product->selling_price) }}</td>
                <td class="p-2 border text-right">{{ number_format($product->profit_per_unit) }}</td>
                <td class="p-2 border text-right">{{ number_format($product->total_profit) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
