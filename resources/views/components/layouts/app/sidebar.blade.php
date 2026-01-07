<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="shopping-cart" :href="route('pos.index')" :current="request()->routeIs('pos.index')" wire:navigate>{{ __('Point of Sale') }}</flux:navlist.item>
                </flux:navlist.group>

                @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                    <flux:navlist.group expandable :expanded="false" heading="Products" class="grid">
                        <flux:navlist.item icon="home" :href="route('products.add')" :current="request()->routeIs('products.add')" wire:navigate>{{ __('Add New Products') }}</flux:navlist.item>
                        <flux:navlist.item icon="shopping-cart" :href="route('stock.in')" :current="request()->routeIs('stock.in')" wire:navigate>{{ __('Stock In') }}</flux:navlist.item>
                        <flux:navlist.item icon="shopping-cart" :href="route('stock.out')" :current="request()->routeIs('stock.out')" wire:navigate>{{ __('Stock Out') }}</flux:navlist.item>
                    </flux:navlist.group>
                @endif

                <flux:navlist.group expandable :expanded="false" :heading="__('Staff')" class="grid">
                    @if(auth()->user()->isAdmin())
                        <flux:navlist.item icon="home" :href="route('users.manage')" :current="request()->routeIs('users.manage')" wire:navigate>{{ __('Staff Member') }}</flux:navlist.item>
                    @endif
                    <flux:navlist.item icon="shopping-cart" :href="route('profile.edit')" :current="request()->routeIs('profile.edit')" wire:navigate>{{ __('My Profile') }}</flux:navlist.item>
                    <flux:navlist.item icon="shopping-cart" :href="route('user-password.edit')" :current="request()->routeIs('user-password.edit')" wire:navigate>{{ __('Change Password') }}</flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group class="grid">
                   
                </flux:navlist.group>
            </flux:navlist>
            

            <flux:spacer />

            @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                <flux:navlist.group expandable :expanded="false" :heading="__('Reports')" class="grid">
                    <flux:navlist.item icon="home" :href="route('reports.daily-sales')" :current="request()->routeIs('reports.daily-sales')" wire:navigate>{{ __('Today Sales') }}</flux:navlist.item>
                    <flux:navlist.item icon="shopping-cart" :href="route('reports.my-daily-sales')" :current="request()->routeIs('reports.my-daily-sales')" wire:navigate>{{ __('My Sales') }}</flux:navlist.item>
                    <flux:navlist.item icon="document-text" :href="route('reports.daily-stock')" :current="request()->routeIs('reports.daily-stock')" wire:navigate>{{ __('Daily Stock Report') }}</flux:navlist.item>
                    <flux:navlist.item icon="shopping-cart" :href="route('reports.out-of-stock')" :current="request()->routeIs('reports.out-of-stock')" wire:navigate>{{ __('Out of Stock') }}</flux:navlist.item>
                    <flux:navlist.item icon="shopping-cart" :href="route('reports.profit')" :current="request()->routeIs('reports.profit')" wire:navigate>{{ __('Stock Profit') }}</flux:navlist.item>
                    <flux:navlist.item icon="shopping-cart" :href="route('reports.top-low-items')" :current="request()->routeIs('reports.top-low-items')" wire:navigate>{{ __('Top low Stock') }}</flux:navlist.item>
                    <flux:navlist.item icon="shopping-cart" :href="route('reports.physical-count')" :current="request()->routeIs('reports.physical-count')" wire:navigate>{{ __('Physical Count Report') }}</flux:navlist.item>
                </flux:navlist.group>
            @else
                <flux:navlist.group expandable :expanded="false" :heading="__('Reports')" class="grid">
                    <flux:navlist.item icon="shopping-cart" :href="route('reports.my-daily-sales')" :current="request()->routeIs('reports.my-daily-sales')" wire:navigate>{{ __('My Sales') }}</flux:navlist.item>
                </flux:navlist.group>
            @endif

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
