<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-gray-900">
        <div class="min-h-screen flex items-center justify-center bg-cover relative"
         style="background-image: url('{{ asset('images/beer20.jpg') }}');">
            <!-- Dark overlay for better contrast in both modes -->
            <div class="absolute inset-0 bg-black/40 dark:bg-black/60"></div>
            
            <div class="flex w-full max-w-sm flex-col gap-2 relative z-10">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex h-9 w-9 mb-1 items-center justify-center rounded-md">
                        <x-app-logo-icon class="size-9 fill-current text-white drop-shadow-lg" />
                    </span>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
