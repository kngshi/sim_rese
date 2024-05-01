<x-guest-layout>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Atte</title>
        <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        <script src="https://kit.fontawesome.com/7f44e1f3ad.js" crossorigin="anonymous"></script>
    </head>

    <header class="header">
        <div class="header__inner">
            <div class="header__logo">Rese</div>
        </div>
    </header>
    <x-auth-card>
        <x-slot name="logo">
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />


        <div class="form_ttl">Login</div>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <i class="fa-solid fa-envelope"></i>
                <x-label for="email" :value="__('')" />

                <x-input id="email" class="block mt-4 w-full" type="email" name="email" placeholder="Email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <i class="fa-solid fa-unlock-keyhole fa-lg"></i>
                <x-label for="password" :value="__('')" />
                <x-input id="password" class="block w-full"
                                type="password"
                                name="password"
                                placeholder="Password"
                                required autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('ログイン') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
