<div class="flex flex-col lg:flex-row min-h-screen gap-4 p-4 bg-gray-50 dark:bg-gray-900">

    {{-- Success/Error Messages --}}
    @if(session()->has('success'))
        <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Categories Sidebar --}}
    <aside class="lg:w-1/5 w-full bg-gray-100 dark:bg-gray-800 p-3 rounded shadow-md overflow-y-auto h-[calc(100vh-2rem)]">
        <h3 class="font-bold mb-4 text-gray-800 dark:text-gray-100">Categories</h3>

        @foreach($categories as $category)
            <div class="mb-2 font-semibold text-gray-700 dark:text-gray-200">{{ $category->name }}</div>
            @foreach($category->children as $child)
                <button wire:click="selectCategory({{ $child->id }})"
                    class="block w-full text-left px-4 py-2 mb-1 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 hover:bg-blue-100 dark:hover:bg-blue-600 rounded transition">
                    {{ $child->name }} ({{ $child->products_count ?? 0 }})
                </button>
            @endforeach
        @endforeach
    </aside>

    {{-- Products + Checkout Column --}}
    <main class="lg:w-4/5 w-full flex flex-col gap-4">

        {{-- Search Bar --}}
        <div class="w-full">
            <input type="text"
                placeholder="Search products..."
                wire:model.live.debounce.300ms="search"
                class="w-full border rounded px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-300">
        </div>

        {{-- Products Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach($products as $product)
                @php
                    $inCart = $cart[$product->id]['qty'] ?? 0;
                    $remainingStock = $product->current_stock - $inCart;
                @endphp

                <button wire:click="addToCart({{ $product->id }})"
                    class="border p-3 rounded flex flex-col items-center text-center transition hover:shadow-md hover:bg-green-100 dark:hover:bg-green-700 {{ $remainingStock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                    @if($remainingStock <= 0) disabled @endif>

                    <div class="font-semibold mb-1 text-gray-800 dark:text-gray-100" wire:ignore>
                        {!! $this->highlight($product->name) !!}
                    </div>

                    <div class="text-sm text-gray-600 dark:text-gray-300">Price: {{ number_format($product->sell_price) }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">In Cart: {{ $inCart }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Stock: {{ $remainingStock }}</div>
                </button>
            @endforeach
        </div>

        {{-- Checkout / Cart Panel --}}
        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded shadow-md mt-4">
            <h3 class="font-bold mb-4 text-gray-800 dark:text-gray-100">Cart</h3>

            @if(empty($cart))
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <p>Cart is empty</p>
                    <p class="text-sm mt-2">Add products to start a sale</p>
                </div>
            @else
                @foreach($cart as $id => $item)
                    <div class="mb-2 border-b border-gray-200 dark:border-gray-700 pb-2 flex flex-col sm:flex-row items-center gap-2">
                        <div class="flex-1 font-semibold text-gray-800 dark:text-gray-100">{{ $item['name'] }}</div>
                        
                        <input type="number" min="1" value="{{ $item['qty'] }}"
                            wire:change="updateQty({{ $id }}, $event.target.value)"
                            class="w-16 border rounded px-2 py-1 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">

                        @if($useDiscount)
                            <input type="number" min="0" value="{{ $item['discount'] ?? 0 }}"
                                wire:change="updateDiscount({{ $id }}, $event.target.value, 'amount')"
                                class="w-20 border rounded px-2 py-1 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100"
                                placeholder="Discount">
                        @endif

                        <span class="ml-auto font-semibold text-gray-800 dark:text-gray-100">
                            {{ number_format(($item['price'] * $item['qty']) - ($item['discount'] ?? 0)) }}
                        </span>

                        <button wire:click="removeFromCart({{ $id }})" class="text-red-600 font-bold">✕</button>
                    </div>
                @endforeach

                <hr class="my-3 border-gray-300 dark:border-gray-600">

                <div class="font-bold mb-2 text-gray-800 dark:text-gray-100">
                    Total: {{ number_format($this->cartTotal) }}
                </div>

                <select wire:model="paymentMethod" class="w-full mb-2 border rounded p-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                    <option value="cash">Cash</option>
                    <option value="mpesa">M-Pesa</option>
                    <option value="card">Card</option>
                </select>

                <button wire:click="checkout" 
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed"
                    class="w-full bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white py-2 rounded transition">
                    <span wire:loading.remove wire:target="checkout">Checkout</span>
                    <span wire:loading wire:target="checkout">Processing...</span>
                </button>
            @endif
        </div>
    </main>

</div>
