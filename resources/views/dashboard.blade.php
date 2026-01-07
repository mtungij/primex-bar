<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
           <div class="rounded-2xl p-5 shadow-lg
            bg-gradient-to-r from-cyan-500 to-blue-500
            text-white w-full">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium opacity-90">
                Today Sales
            </p>
            <h2 class="text-3xl font-bold mt-1">
                TZS 1,250,000
            </h2>
        </div>

        <!-- SVG Icon -->
        <div class="bg-white/20 p-3 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-7 h-7"
                 fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8c-1.657 0-3 .895-3 2v4c0 1.105 1.343 2 3 2s3-.895 3-2v-4c0-1.105-1.343-2-3-2z"/>
            </svg>
        </div>
    </div>

    <p class="text-xs opacity-80 mt-4">
        +12% from yesterday
    </p>
</div>

          <div class="rounded-2xl p-5 shadow-lg
            bg-gradient-to-r from-purple-500 to-indigo-500
            text-white w-full">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium opacity-90">
                Profit Today
            </p>
            <h2 class="text-3xl font-bold mt-1">
                146
            </h2>
        </div>

        <div class="bg-white/20 p-3 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-7 h-7"
                 fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h18l-1.5 9h-15zM5 21h2m10 0h2"/>
            </svg>
        </div>
    </div>

    <p class="text-xs opacity-80 mt-4">
        +8 new orders
    </p>
</div>

           <div class="rounded-2xl p-5 shadow-lg
            bg-gradient-to-r from-emerald-500 to-green-600
            text-white w-full">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium opacity-90">
                Total Products
            </p>
            <h2 class="text-3xl font-bold mt-1">
                430
            </h2>
        </div>

        <div class="bg-white/20 p-3 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-7 h-7"
                 fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6v12m6-6H6"/>
            </svg>
        </div>
    </div>

    <p class="text-xs opacity-80 mt-4">
        
    </p>
</div>








<div class="bg-white dark:bg-gray-900
            rounded-2xl shadow-md
            border border-gray-200 dark:border-gray-700
            p-5 w-full">

    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold text-lg text-gray-900 dark:text-white">
            Today Products Summary
        </h3>

        <!-- SVG Icon -->
        <svg class="w-6 h-6 text-gray-400 dark:text-gray-500"
             fill="none" stroke="currentColor"
             viewBox="0 0 24 24">
            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  d="M9 5h6M9 12h6M9 19h6"/>
        </svg>
    </div>

    <!-- List -->
    <ul class="space-y-3 text-sm">
        <li class="flex justify-between items-center">
            <span class="text-gray-600 dark:text-gray-400">
                Total Orders
            </span>
            <span class="font-semibold text-gray-900 dark:text-white">
                146
            </span>
        </li>

        <li class="flex justify-between items-center">
            <span class="text-gray-600 dark:text-gray-400">
                Sold Today Total
            </span>
            <span class="font-semibold text-emerald-600 dark:text-emerald-400">
                100
            </span>
        </li>

      

        <li class="flex justify-between items-center pt-3 border-t
                   border-gray-200 dark:border-gray-700">
            <span class="font-semibold text-gray-900 dark:text-white">
              Remaining Stock Value
            </span>
            <span class="font-bold text-cyan-600 dark:text-cyan-400">
                46
            </span>
        </li>
    </ul>
</div>

<div class="bg-white dark:bg-gray-900
            rounded-2xl shadow-md
            border border-gray-200 dark:border-gray-700
            overflow-hidden w-full">

    <!-- Gradient Header -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600
                p-4 text-white">
        <h3 class="font-semibold text-lg">
            Top 5 Selling Drinks Today
        </h3>
    </div>

    <!-- List -->
    <ul class="p-5 space-y-3 text-sm">
        <li class="flex justify-between">
            <span class="text-gray-600 dark:text-gray-400">
                Kilimanjaro Lager
            </span>
            <span class="font-semibold">
                42 sold
            </span>
        </li>

        <li class="flex justify-between">
            <span class="text-gray-600 dark:text-gray-400">
                Serengeti Lite
            </span>
            <span class="font-semibold">
                35 sold
            </span>
        </li>

        <li class="flex justify-between">
            <span class="text-gray-600 dark:text-gray-400">
                Johnnie Walker
            </span>
            <span class="font-semibold">
                18 sold
            </span>
        </li>
         <li class="flex justify-between">
            <span class="text-gray-600 dark:text-gray-400">
                Johnnie Walker
            </span>
            <span class="font-semibold">
                18 sold
            </span>
        </li>
         <li class="flex justify-between">
            <span class="text-gray-600 dark:text-gray-400">
                Johnnie Walker
            </span>
            <span class="font-semibold">
                18 sold
            </span>
        </li>
    </ul>
</div>

<div class="bg-white dark:bg-gray-900
            rounded-2xl shadow-md p-5
            border border-gray-200 dark:border-gray-700">

    <h3 class="font-semibold text-lg mb-4 text-gray-900 dark:text-white">
      Top 5 Low Stock Alert
    </h3>

    <ul class="space-y-3 text-sm">
        <li class="flex items-center justify-between">
            <span>Kilimanjaro Lager</span>
            <span class="px-2 py-0.5 text-xs rounded-full
                         bg-red-100 text-red-600
                         dark:bg-red-900/30 dark:text-red-400">
                3 left
            </span>
        </li>

          <li class="flex items-center justify-between">
            <span>Kilimanjaro Lager</span>
            <span class="px-2 py-0.5 text-xs rounded-full
                         bg-red-100 text-red-600
                         dark:bg-red-900/30 dark:text-red-400">
                3 left
            </span>
        </li>

          <li class="flex items-center justify-between">
            <span>Kilimanjaro Lager</span>
            <span class="px-2 py-0.5 text-xs rounded-full
                         bg-red-100 text-red-600
                         dark:bg-red-900/30 dark:text-red-400">
                3 left
            </span>
        </li>

          <li class="flex items-center justify-between">
            <span>Kilimanjaro Lager</span>
            <span class="px-2 py-0.5 text-xs rounded-full
                         bg-red-100 text-red-600
                         dark:bg-red-900/30 dark:text-red-400">
                3 left
            </span>
        </li>

        <li class="flex items-center justify-between">
            <span>Smirnoff Vodka</span>
            <span class="px-2 py-0.5 text-xs rounded-full
                         bg-orange-100 text-orange-600
                         dark:bg-orange-900/30 dark:text-orange-400">
                6 left
            </span>
        </li>
    </ul>
</div>


        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts.app>
