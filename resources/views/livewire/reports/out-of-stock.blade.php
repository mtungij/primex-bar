<div>
    <h2 class="text-xl font-bold mb-4">Out of Stock Report</h2>

    @if($products->isEmpty())
        <div class="p-4 bg-green-100 rounded text-green-700">
            All products are in stock.
        </div>
    @else
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Product</th>
                    <th class="p-2 text-left">Category</th>
                    <th class="p-2 text-right">Price</th>
                    <th class="p-2 text-right">Current Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="border-t">
                        <td class="p-2">{{ $product->name }}</td>
                        <td class="p-2">{{ $product->category->name ?? '-' }}</td>
                        <td class="p-2 text-right">{{ number_format($product->sell_price) }}</td>
                        <td class="p-2 text-right">{{ $product->current_stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
