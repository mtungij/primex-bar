<div class="w-full max-w-full sm:max-w-lg lg:max-w-xl mx-auto
            bg-white dark:bg-gray-900
            p-4 sm:p-6
            rounded-xl shadow-md">

    {{-- Error --}}
    @if (session()->has('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- Success --}}
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <h3 class="font-bold text-lg sm:text-xl mb-4 text-cyan-700 dark:text-cyan-400">
        Stock OUT / Adjustment
    </h3>

    {{-- Product Selection --}}
    <div class="mb-4">
        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            Select Product
        </label>
        <select wire:model="selectedProduct"
            class="w-full rounded-lg border border-gray-300 dark:border-gray-700
                   bg-white dark:bg-gray-800
                   p-2.5
                   focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
            <option value="">-- choose product --</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}">
                    {{ $product->name }} (Current: {{ $product->current_stock }})
                </option>
            @endforeach
        </select>
    </div>

    {{-- Quantity --}}
    <div class="mb-4">
        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            Quantity
        </label>
        <input type="number" min="1" wire:model="qty"
            class="w-full rounded-lg border border-gray-300 dark:border-gray-700
                   bg-white dark:bg-gray-800
                   p-2.5
                   focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
    </div>

    {{-- Reason --}}
    <div class="mb-5">
        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            Reason
        </label>
        <select wire:model="reason"
            class="w-full rounded-lg border border-gray-300 dark:border-gray-700
                   bg-white dark:bg-gray-800
                   p-2.5
                   focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
            <option value="damage">Damage</option>
            <option value="spoilage">Spoilage</option>
            <option value="adjustment">Adjustment</option>
        </select>
    </div>

    <button wire:click="removeStock"
        class="w-full bg-cyan-600 hover:bg-cyan-700
               text-white font-semibold
               py-2.5 rounded-lg
               transition duration-200">
        Remove Stock
    </button>

</div>
