<div class="p-6">
    <flux:card class="space-y-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="lg">Daily Stock Report</flux:heading>
                <flux:subheading>Complete inventory movement and profit analysis</flux:subheading>
            </div>
            <div class="flex gap-3">
                <flux:input 
                    type="date" 
                    wire:model.live="reportDate" 
                    label="Report Date"
                />
                <flux:button wire:click="exportPdf" variant="primary" icon="arrow-down-tray">
                    Export PDF
                </flux:button>
            </div>
        </div>

        <flux:separator />

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
            <flux:table>
                <flux:columns>
                    <flux:column class="w-16">S/N</flux:column>
                    <flux:column>Product Name</flux:column>
                    <flux:column>Category</flux:column>
                    <flux:column class="text-right">Opening Stock</flux:column>
                    <flux:column class="text-right">Added Stock</flux:column>
                    <flux:column class="text-right">Buy Price</flux:column>
                    <flux:column class="text-right">Sell Price</flux:column>
                    <flux:column class="text-right">Sold Today</flux:column>
                    <flux:column class="text-right">Closing Stock</flux:column>
                    <flux:column class="text-right">Buy Value</flux:column>
                    <flux:column class="text-right">Sell Value</flux:column>
                    <flux:column class="text-right">Profit</flux:column>
                </flux:columns>

                <flux:rows>
                    @forelse($reportData as $row)
                        <flux:row>
                            <flux:cell class="font-mono text-sm">{{ $row['sn'] }}</flux:cell>
                            <flux:cell class="font-medium">{{ $row['product_name'] }}</flux:cell>
                            <flux:cell>
                                <flux:badge size="sm" color="zinc">{{ $row['category'] }}</flux:badge>
                            </flux:cell>
                            <flux:cell class="text-right font-mono">{{ number_format($row['opening_stock']) }}</flux:cell>
                            <flux:cell class="text-right font-mono text-green-600 dark:text-green-400">
                                {{ $row['added_stock'] > 0 ? '+' . number_format($row['added_stock']) : '-' }}
                            </flux:cell>
                            <flux:cell class="text-right font-mono">{{ number_format($row['buy_price'], 0) }}</flux:cell>
                            <flux:cell class="text-right font-mono">{{ number_format($row['sell_price'], 0) }}</flux:cell>
                            <flux:cell class="text-right font-mono text-red-600 dark:text-red-400">
                                {{ $row['sold_today'] > 0 ? '-' . number_format($row['sold_today']) : '-' }}
                            </flux:cell>
                            <flux:cell class="text-right font-mono">{{ number_format($row['closing_stock']) }}</flux:cell>
                            <flux:cell class="text-right font-mono">{{ number_format($row['buy_value'], 0) }}</flux:cell>
                            <flux:cell class="text-right font-mono">{{ number_format($row['sell_value'], 0) }}</flux:cell>
                            <flux:cell class="text-right font-mono">
                                <span class="@if($row['profit'] > 0) text-emerald-600 dark:text-emerald-400 @elseif($row['profit'] < 0) text-red-600 dark:text-red-400 @endif font-semibold">
                                    {{ number_format($row['profit'], 0) }}
                                </span>
                            </flux:cell>
                        </flux:row>
                    @empty
                        <flux:row>
                            <flux:cell colspan="12" class="text-center py-8 text-gray-500">
                                No products found
                            </flux:cell>
                        </flux:row>
                    @endforelse
                </flux:rows>
            </flux:table>
        </div>

        {{-- Footer Totals --}}
        <div class="border-t pt-4">
            <div class="flex justify-end gap-8 text-sm font-semibold">
                <div>Total Opening: <span class="text-blue-600">{{ number_format($totals['opening_stock']) }}</span></div>
                <div>Total Added: <span class="text-green-600">{{ number_format($totals['added_stock']) }}</span></div>
                <div>Total Sold: <span class="text-red-600">{{ number_format($totals['sold_qty']) }}</span></div>
                <div>Total Closing: <span class="text-purple-600">{{ number_format($totals['closing_stock']) }}</span></div>
                <div>Total Profit: <span class="text-emerald-600">{{ number_format($totals['profit'], 0) }}</span></div>
            </div>
        </div>
    </flux:card>
</div>
