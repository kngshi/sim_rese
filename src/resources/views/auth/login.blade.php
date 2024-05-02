<x-guest-layout>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Rese</title>
        <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        <script src="https://kit.fontawesome.com/7f44e1f3ad.js" crossorigin="anonymous"></script>
    </head>

    <header class="header">
        <div class="header__inner">
            <a href="#modal-01">
            <div class="openbtn6"><span></span><span></span><span></span></div>
            </a>
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
            <table>
            <tr>
            <th class="form-icon">
                <i class="fa-solid fa-envelope fa-xl"></i>
            </th>
            <td class="form-input">
                <x-input id="email" class="block mt-4 w-full border-none" type="email" name="email" :value="old('email')" placeholder="Email" required /></td>
            </tr>
            <tr>
            <th class="form-icon">
                <i class="fa-solid fa-unlock-keyhole fa-xl"></i>
            </th>
            <td class="form-input"><x-input id="password" class="block mt-1 w-full border-none"
                                type="password"
                                name="password"
                                placeholder="Password"
                                required autocomplete="new-password" /></td>
            </tr>
            </table>
            <div class="flex items-center justify-end">
                <x-button class="form-button">
                    {{ __('ログイン') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
    <!-- モーダルウィンドウ -->
<div class="modal-wrapper" id="modal-01">
  <a href="#!" class="modal-overlay"></a>
  <div class="modal-window">
    <div class="modal-content">
      <ul>
            <li><a href="{{ route('login') }}">Home</a></li>
            <li><a href="{{ route('register') }}">Registration</a></li>
            <li><a href="{{ route('login') }}">Login</a></li>
        </ul>
    </div>
    <a href="#!" class="modal-close">×</a>
  </div>
</div>
</x-guest-layout>
