<html>
    <x-guest-layout>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Atte</title>
        <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/register.css') }}">
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

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="form_ttl">Registration</div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <!-- Name -->
            <div>
                <i class="fa-solid fa-user fa-xl"></i>
                <x-label class="mt-1" for="name"  :value="__('')" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Username" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <i class="fa-solid fa-envelope"></i>
                <x-label for="email" :value="__('')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Email" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <i class="fa-solid fa-unlock-keyhole fa-lg"></i>
                <x-label for="password" :value="__('')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                placeholder="Password"
                                required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('登録') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
</html>