<html>
  <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Rese</title>
        <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
        <script src="https://kit.fontawesome.com/7f44e1f3ad.js" crossorigin="anonymous"></script>
    </head>
    <header class="header">
        <div class="header__inner">
            <div class="header__logo">Rese</div>
        </div>
    </header>
    <x-guest-layout>
    <x-auth-card class="card">
        <x-slot name="logo">
        </x-slot>
        <div class="content">
        <div class="message">会員登録ありがとうございます</div> 
                <x-button class="form-button" >
                    {{ __('ログインする') }}
                </x-button>
        </div>
        </div>
    </x-auth-card>
</x-guest-layout>
</html>