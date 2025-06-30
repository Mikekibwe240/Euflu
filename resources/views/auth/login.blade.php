<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-200 via-blue-400 to-blue-600 dark:from-gray-900 dark:via-blue-900 dark:to-blue-800">
        <div class="w-full max-w-md mx-auto bg-white dark:bg-gray-900 rounded-3xl shadow-2xl p-10 border-2 border-blue-200 dark:border-blue-800">
            <div class="flex flex-col items-center mb-6">
                <!-- Logo supprimé -->
                <h1 class="text-4xl font-extrabold text-center mb-2 text-blue-800 dark:text-blue-300 tracking-wide drop-shadow">Admin EUFLU D1</h1>
                <h2 class="text-xl font-semibold text-center text-gray-900 dark:text-gray-100 mb-2">Se connecter</h2>
            </div>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-base font-semibold" />
                    <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-blue-400" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-base font-semibold" />
                    <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-blue-400" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <!-- Remember Me -->
                <div class="flex items-center mb-2">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-400" name="remember">
                    <label for="remember_me" class="ml-2 text-sm text-gray-600 dark:text-gray-300">{{ __('Remember me') }}</label>
                </div>
                <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-blue-600 dark:text-blue-300 hover:text-blue-900 dark:hover:text-white font-semibold" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                    <button type="submit" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-900 text-white font-bold px-6 py-2 rounded-lg shadow transition-all text-base focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" /></svg>
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
