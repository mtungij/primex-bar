<div class="p-6">
    <div class="space-y-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daily Stock Report</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Complete inventory movement and profit analysis</p>
            </div>
            <div class="flex gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Report Date</label>
                    <input 
                        type="date" 
                        wire:model.live="reportDate"
                        class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    />
                </div>
                <div class="flex items-end">
                    <button wire:click="exportPdf" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Export PDF
                    </button>
                </div>
            </div>
        </div>

        <hr class="border-gray-200 dark:border-gray-700" />

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                <div class="text-sm text-blue-600 dark:text-blue-400">Opening Stock</div>
                <div class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ number_format($totals['opening_stock']) }}</div>
            </div>
            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                <div class="text-sm text-green-600 dark:text-green-400">Added Stock</div>
                <div class="text-2xl font-bold text-green-700 dark:text-green-300">{{ number_format($totals['added_stock']) }}</div>
            </div>
            <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg">
                <div class="text-sm text-red-600 dark:text-red-400">Sold Qty</div>
                <div class="text-2xl font-bold text-red-700 dark:text-red-300">{{ number_format($totals['sold_qty']) }}</div>
            </div>
            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                <div class="text-sm text-purple-600 dark:text-purple-400">Closing Stock</div>
                <div class="text-2xl font-bold text-purple-700 dark:text-purple-300">{{ number_format($totals['closing_stock']) }}</div>
            </div>
            <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg">
                <div class="text-sm text-orange-600 dark:text-orange-400">Buy Value</div>
                <div class="text-2xl font-bold text-orange-700 dark:text-orange-300">{{ number_format($totals['buy_value'], 0) }}</div>
            </div>
            <div class="bg-cyan-50 dark:bg-cyan-900/20 p-4 rounded-lg">
                <div class="text-sm text-cyan-600 dark:text-cyan-400">Sell Value</div>
                <div class="text-2xl font-bold text-cyan-700 dark:text-cyan-300">{{ number_format($totals['sell_value'], 0) }}</div>
            </div>
            <div class="bg-emerald-50 dark:bg-emerald-900/20 p-4 rounded-lg">
                <div class="text-sm text-emerald-600 dark:text-emerald-400">Profit</div>
                <div class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">{{ number_format($totals['profit'], 0) }}</div>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-16">S/N</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Product Name</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                        <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Opening Stock</th>
                        <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Added Stock</th>
                        <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Buy Price</th>
                        <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sell Price</th>
                        <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sold Today</th>
                        <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Closing Stock</th>
                        <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Buy Value</th>
                        <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sell Value</th>
                        <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Profit</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($reportData as $row)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-mono text-gray-900 dark:text-gray-100">{{ $row['sn'] }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $row['product_name'] }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                    {{ $row['category'] }}
                                </span>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-right font-mono text-gray-900 dark:text-gray-100">{{ number_format($row['opening_stock']) }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-right font-mono text-green-600 dark:text-green-400">
                                {{ $row['added_stock'] > 0 ? '+' . number_format($row['added_stock']) : '-' }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-right font-mono text-gray-900 dark:text-gray-100">{{ number_format($row['buy_price'], 0) }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-right font-mono text-gray-900 dark:text-gray-100">{{ number_format($row['sell_price'], 0) }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-right font-mono text-red-600 dark:text-red-400">
                                {{ $row['sold_today'] > 0 ? '-' . number_format($row['sold_today']) : '-' }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-right font-mono text-gray-900 dark:text-gray-100">{{ number_format($row['closing_stock']) }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-right font-mono text-gray-900 dark:text-gray-100">{{ number_format($row['buy_value'], 0) }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-right font-mono text-gray-900 dark:text-gray-100">{{ number_format($row['sell_value'], 0) }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-right font-mono">
                                <span class="@if($row['profit'] > 0) text-emerald-600 dark:text-emerald-400 @elseif($row['profit'] < 0) text-red-600 dark:text-red-400 @else text-gray-900 dark:text-gray-100 @endif font-semibold">
                                    {{ number_format($row['profit'], 0) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="px-3 py-8 text-center text-gray-500 dark:text-gray-400">
                                No products found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>border-gray-200 dark:border-gray-700 pt-4">
            <div class="flex justify-end gap-8 text-sm font-semibold text-gray-900 dark:text-gray-100">
                <div>Total Opening: <span class="text-blue-600">{{ number_format($totals['opening_stock']) }}</span></div>
                <div>Total Added: <span class="text-green-600">{{ number_format($totals['added_stock']) }}</span></div>
                <div>Total Sold: <span class="text-red-600">{{ number_format($totals['sold_qty']) }}</span></div>
                <div>Total Closing: <span class="text-purple-600">{{ number_format($totals['closing_stock']) }}</span></div>
                <div>Total Profit: <span class="text-emerald-600">{{ number_format($totals['profit'], 0) }}</span></div>
            </div>
        </div>

            </div>
        
    </flux:card>
</div>
