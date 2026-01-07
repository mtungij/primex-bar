<div class="p-4">

    <h3 class="text-center font-bold text-xl mb-4">Physical Counting Report</h3>

    <div class="mb-4">
        <label class="font-semibold">Date of Counting:</label>
        <input type="date" wire:model="date" class="border rounded p-2">
    </div>

    @foreach($products->groupBy('category.name') as $categoryName => $items)
        <div class="mb-6">
            <h4 class="font-bold mb-2">{{ $categoryName ?? 'Uncategorized' }}</h4>
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2 text-center">S/N</th>
                        <th class="border p-2 text-left">Product</th>
                        <th class="border p-2 text-center">System Stock</th>
                        <th class="border p-2 text-center">Physical Count</th>
                        <th class="border p-2 text-left">Inspected By</th>
                        <th class="border p-2 text-left">Approved By</th>
                        <th class="border p-2 text-center">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $index => $product)
                        <tr>
                            <td class="border p-2 text-center">{{ $index + 1 }}</td>
                            <td class="border p-2">{{ $product->name }}</td>
                            <td class="border p-2 text-center">{{ $product->current_stock }}</td>
                            <td class="border p-2 text-center">
                            
                            </td>
                            <td class="border p-2"></td>
                            <td class="border p-2"></td>
                            <td class="border p-2 text-center">{{ $date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

</div>
