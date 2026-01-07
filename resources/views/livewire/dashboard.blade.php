<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        {{-- Today Sales Card --}}
        <div class="rounded-2xl p-5 shadow-lg bg-gradient-to-r from-cyan-500 to-blue-500 text-white w-full">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Today Sales</p>
                    <h2 class="text-3xl font-bold mt-1">
                        TZS {{ number_format($todaySales, 0) }}
                    </h2>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2v4c0 1.105 1.343 2 3 2s3-.895 3-2v-4c0-1.105-1.343-2-3-2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs opacity-80 mt-4">
                @if($salesGrowth >= 0)
                    +{{ number_format($salesGrowth, 1) }}% from yesterday
                @else
                    {{ number_format($salesGrowth, 1) }}% from yesterday
                @endif
            </p>
        </div>

        {{-- Profit Today Card --}}
        <div class="rounded-2xl p-5 shadow-lg bg-gradient-to-r from-purple-500 to-indigo-500 text-white w-full">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Profit Today</p>
                    <h2 class="text-3xl font-bold mt-1">
                        TZS {{ number_format($todayProfit, 0) }}
                    </h2>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2v4c0 1.105 1.343 2 3 2s3-.895 3-2v-4c0-1.105-1.343-2-3-2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs opacity-80 mt-4">{{ $totalOrders }} orders today</p>
        </div>

        {{-- Total Products Card --}}
        <div class="rounded-2xl p-5 shadow-lg bg-gradient-to-r from-emerald-500 to-green-600 text-white w-full">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">Total Products</p>
                    <h2 class="text-3xl font-bold mt-1">{{ $totalProducts }}</h2>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs opacity-80 mt-4">Active inventory</p>
        </div>

        {{-- Today Products Summary --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-md border border-gray-200 dark:border-gray-700 p-5 w-full">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-lg text-gray-900 dark:text-white">Today Products Summary</h3>
                <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 5h6M9 12h6M9 19h6"/>
                </svg>
            </div>
            <ul class="space-y-3 text-sm">
                <li class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Total Products</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $totalProducts }}</span>
                </li>
                <li class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Sold Today Total</span>
                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ number_format($soldToday) }}</span>
                </li>
                <li class="flex justify-between items-center pt-3 border-t border-gray-200 dark:border-gray-700">
                    <span class="font-semibold text-gray-900 dark:text-white">Total Stock Quantity</span>
                    <span class="font-bold text-cyan-600 dark:text-cyan-400">{{ number_format($remainingStock) }}</span>
                </li>
            </ul>
        </div>

        {{-- Top 5 Selling Products --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden w-full">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4 text-white">
                <h3 class="font-semibold text-lg">Top 5 Selling Products Today</h3>
            </div>
            <ul class="p-5 space-y-3 text-sm">
                @forelse($topSellingProducts as $product)
                    <li class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">{{ $product->name }}</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($product->total_sold) }} sold</span>
                    </li>
                @empty
                    <li class="text-center text-gray-500 dark:text-gray-400 py-4">No sales today yet</li>
                @endforelse
            </ul>
        </div>

        {{-- Low Stock Alert --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-md p-5 border border-gray-200 dark:border-gray-700">
            <h3 class="font-semibold text-lg mb-4 text-gray-900 dark:text-white">Top 5 Low Stock Alert</h3>
            <ul class="space-y-3 text-sm">
                @forelse($lowStockProducts as $product)
                    <li class="flex items-center justify-between">
                        <span class="text-gray-900 dark:text-white">{{ $product->name }}</span>
                        <span class="px-2 py-0.5 text-xs rounded-full 
                            @if($product->stock_qty <= 3)
                                bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400
                            @elseif($product->stock_qty <= 6)
                                bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400
                            @else
                                bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400
                            @endif
                        ">
                            {{ $product->stock_qty }} left
                        </span>
                    </li>
                @empty
                    <li class="text-center text-gray-500 dark:text-gray-400 py-4">All products well stocked!</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Sales by Category Chart --}}
    <div class="mt-6 bg-white dark:bg-gray-900 rounded-2xl shadow-md p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="font-semibold text-lg mb-4 text-gray-900 dark:text-white">Sales by Category Today</h3>
        <div class="w-full" style="height: 400px;">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('categoryChart');
        const categoryLabels = {!! $categoryLabels !!};
        const categorySales = {!! $categorySales !!};

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Sales Amount (TZS)',
                    data: categorySales,
                    borderColor: 'rgb(6, 182, 212)',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: 'rgb(6, 182, 212)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: document.documentElement.classList.contains('dark') ? '#fff' : '#374151',
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                return 'TZS ' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280',
                            callback: function(value) {
                                return 'TZS ' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
