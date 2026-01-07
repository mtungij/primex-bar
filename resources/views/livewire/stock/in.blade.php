<div
    class="
        w-full
        max-w-full
        sm:max-w-xl
        md:max-w-2xl
        lg:max-w-3xl
        mx-auto
        bg-white
        dark:bg-gray-900
        p-4 sm:p-6
        rounded-xl
        shadow-lg
        border
        border-gray-200
        dark:border-gray-700
    "
>
    {{-- Success Message --}}
    @if (session()->has('success'))
        <div
            class="
                bg-cyan-100
                dark:bg-cyan-900/30
                text-cyan-800
                dark:text-cyan-300
                p-3
                mb-4
                rounded-lg
                text-sm
            "
        >
            {{ session('success') }}
        </div>
    @endif

    <h3
        class="
            font-bold
            text-xl
            mb-4
            text-gray-800
            dark:text-gray-100
        "
    >
        Add Stock (Purchase)
    </h3>

    {{-- Product Selection --}}
    <div class="mb-4">
        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            Select Product
        </label>
        <select
            wire:model="selectedProduct"
            class="
                w-full
                rounded-lg
                border
                border-gray-300
                dark:border-gray-600
                bg-white
                dark:bg-gray-800
                p-2.5
                text-gray-800
                dark:text-gray-100
                focus:ring-2
                focus:ring-cyan-500
                focus:border-cyan-500
            "
        >
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
        <input
            type="number"
            min="1"
            wire:model="qty"
            class="
                w-full
                rounded-lg
                border
                border-gray-300
                dark:border-gray-600
                bg-white
                dark:bg-gray-800
                p-2.5
                text-gray-800
                dark:text-gray-100
                focus:ring-2
                focus:ring-cyan-500
            "
        >
    </div>

    {{-- Buy Price --}}
    <div class="mb-4">
        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            Buy Price
        </label>
        <input
            type="number"
            min="0"
            step="0.01"
            wire:model="buyPrice"
            class="
                w-full
                rounded-lg
                border
                border-gray-300
                dark:border-gray-600
                bg-white
                dark:bg-gray-800
                p-2.5
                text-gray-800
                dark:text-gray-100
                focus:ring-2
                focus:ring-cyan-500
            "
        >
    </div>

    {{-- Sell Price --}}
    <div class="mb-4">
        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            Sell Price
        </label>
        <input
            type="number"
            min="0"
            step="0.01"
            wire:model="sellPrice"
            class="
                w-full
                rounded-lg
                border
                border-gray-300
                dark:border-gray-600
                bg-white
                dark:bg-gray-800
                p-2.5
                text-gray-800
                dark:text-gray-100
                focus:ring-2
                focus:ring-cyan-500
            "
        >
    </div>

    {{-- Reason --}}
    <div class="mb-6">
        <label class="block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            Reason
        </label>
        <select
            wire:model="reason"
            class="
                w-full
                rounded-lg
                border
                border-gray-300
                dark:border-gray-600
                bg-white
                dark:bg-gray-800
                p-2.5
                text-gray-800
                dark:text-gray-100
                focus:ring-2
                focus:ring-cyan-500
            "
        >
            <option value="purchase">Purchase</option>
            <option value="adjustment">Adjustment</option>
        </select>
    </div>

    {{-- Submit Button --}}
    <button
        wire:click="addStock"
        class="
            w-full
            bg-cyan-600
            hover:bg-cyan-700
            active:bg-cyan-800
            text-white
            font-semibold
            py-3
            rounded-lg
            transition
            focus:ring-2
            focus:ring-cyan-400
        "
    >
        Add Stock
    </button>
</div>
