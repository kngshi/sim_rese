<html>
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
    <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
        </x-slot>

       
        <div class="">会員登録ありがとうございます
        </div>
                <x-button class="mt-4">
                    {{ __('ログインする') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
</html>