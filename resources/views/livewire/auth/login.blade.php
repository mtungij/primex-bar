


<x-layouts.auth>
   

        <div class="bg-white/80 backdrop-blur-md p-8 rounded-lg shadow-lg w-full max-w-md">
            <x-auth-header
                :title="__('BAR SYSTEM LOGIN')"
                :description="__('Enter your email and password below to log in')" />

            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
 <flux:input
    name="email"
    :label="__('Email address')"
    type="email"
    placeholder="email@example.com"
    class:input="
        text-white
        placeholder:text-white/70
      
        border-white/30
        focus:border-white
        focus:ring-white
    "
    label-class="text-white"
/>



            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('Log in') }}
                </flux:button>
            </div>
        </form>

          {{-- @if (Route::has('register'))
            <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
                <span>{{ __('Don\'t have an account?') }}</span>
                <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
            </div>
        @endif --}}
<div class="text-center mt-4">
      <a
        href="https://wa.me/255629364847"
        target="_blank"
        class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-medium"
    >
       

        <span>Unahitaji msaada? Bonyeza hapa WhatsApp</span>
    </a>
</div>

        </div>

    </div>
</x-layouts.auth>
