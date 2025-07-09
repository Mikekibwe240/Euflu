@extends('layouts.public')

@section('title', 'Connexion')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md mx-auto bg-white dark:bg-[#23272a] rounded-3xl shadow-2xl p-10 border-2 border-[#E2001A]">
        <div class="flex flex-col items-center mb-6">
            <h1 class="text-4xl font-extrabold text-center mb-2 text-[#E2001A] tracking-wide drop-shadow" style="font-family: 'Montserrat', Arial, Helvetica, sans-serif;">Admin EUFLU D1</h1>
            <h2 class="text-xl font-semibold text-center text-gray-900 dark:text-gray-100 mb-2">Se connecter</h2>
        </div>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-base font-semibold" />
                <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-[#E2001A]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-base font-semibold" />
                <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-[#E2001A]" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <!-- Remember Me -->
            <div class="flex items-center mb-2">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#E2001A] shadow-sm focus:ring-[#E2001A]" name="remember">
                <label for="remember_me" class="ml-2 text-sm text-gray-600 dark:text-gray-300">{{ __('Remember me') }}</label>
            </div>
            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-[#E2001A] hover:text-[#b30016] font-semibold" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <button type="submit" class="inline-flex items-center gap-2 bg-[#E2001A] hover:bg-[#b30016] text-white font-bold px-6 py-2 rounded-lg shadow transition-all text-base focus:outline-none focus:ring-2 focus:ring-[#E2001A]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" /></svg>
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
