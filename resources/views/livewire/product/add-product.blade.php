<div class="w-full p-6 rounded-xl shadow bg-white dark:bg-gray-800">

    {{-- Success Message --}}
    @if(session()->has('success'))
        <div class="bg-cyan-100 dark:bg-cyan-700 text-cyan-700 dark:text-cyan-100 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="bg-red-100 dark:bg-red-700 text-red-700 dark:text-red-100 p-3 mb-4 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h3 class="text-xl font-bold mb-6 text-gray-800 dark:text-gray-100">
        Add New Product And Its Category
    </h3>

    {{-- Grid Form --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- Product Name --}}
        <div>
            <label class="block font-semibold mb-1 text-gray-700 dark:text-gray-200">
                Product Name
            </label>
            <input type="text" wire:model="name"
                class="w-full border rounded-lg p-2 bg-white dark:bg-gray-700
                text-gray-800 dark:text-gray-100
                focus:ring-2 focus:ring-cyan-500 focus:outline-none">
        </div>

        {{-- Category --}}
        <div>
            <label class="block font-semibold mb-1 text-gray-700 dark:text-gray-200">
                Category
            </label>
            <select wire:model="category_id"
                class="w-full border rounded-lg p-2 bg-white dark:bg-gray-700
                text-gray-800 dark:text-gray-100
                focus:ring-2 focus:ring-cyan-500 focus:outline-none">
                <option value="">-- choose category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Hidden Fields --}}
       <input type="hidden" wire:model="buy_price" value="0">
        <input type="hidden" wire:model="sell_price" value="0">
          <input type="hidden" wire:model="stock_qty" value="0">


        {{-- Stock Quantity --}}
        {{-- <div>
            <label class="block font-semibold mb-1 text-gray-700 dark:text-gray-200">
                Stock Quantity
            </label>
            <input type="number" min="0" wire:model="stock_qty"
                class="w-full border rounded-lg p-2 bg-white dark:bg-gray-700
                text-gray-800 dark:text-gray-100
                focus:ring-2 focus:ring-cyan-500 focus:outline-none">
        </div> --}}

        {{-- Unit --}}
        {{-- <div>
            <label class="block font-semibold mb-1 text-gray-700 dark:text-gray-200">
                Unit
            </label>
            <input type="text" wire:model="unit" placeholder="e.g., pcs, bottles"
                class="w-full border rounded-lg p-2 bg-white dark:bg-gray-700
                text-gray-800 dark:text-gray-100
                focus:ring-2 focus:ring-cyan-500 focus:outline-none">
        </div> --}}
    </div>

    {{-- Submit Button --}}
    <button wire:click="addProduct"
        class="w-full mt-6 bg-cyan-600 hover:bg-cyan-700
        dark:bg-cyan-500 dark:hover:bg-cyan-600
        text-white font-semibold py-3 rounded-lg transition">
        Add Product
    </button>

</div>
