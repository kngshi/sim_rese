<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rese</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  @yield('css')
  <script src="https://kit.fontawesome.com/7f44e1f3ad.js" crossorigin="anonymous"></script>
</head>
<body>
<header class="header">
    <div class="header__inner">
    @if(auth()->check())
    <a href="#modal-02">
        <div class="openbtn6"><span></span><span></span><span></span></div>
    </a>
    @else
    <a href="#modal-01">
        <div class="openbtn6"><span></span><span></span><span></span></div>
    </a>
    @endif
    <div class="header__logo">Rese</div>
    @yield('search-form')
    </div>
</header>
<main>
    @yield('content')
    <!-- モーダルウィンドウ -->
    @if(auth()->check())
    <div class="modal-wrapper" id="modal-02">
        <a href="#!" class="modal-overlay"></a>
        <div class="modal-window">
            <div class="modal-content">
                <ul>
                <li><a href="/">Home</a></li>
                <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                <x-responsive-nav-link :href="route('logout')" class="logout"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Logout') }}
                </x-responsive-nav-link>
                </form>
                </li>
                <li><a href="/mypage">Mypage</a></li>
                </ul>
            </div>
            <a href="#!" class="modal-close">×</a>
        </div>
    </div>
    @else
    <div class="modal-wrapper" id="modal-01">
        <a href="#!" class="modal-overlay"></a>
        <div class="modal-window">
            <div class="modal-content">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="{{ route('register') }}">Registration</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
            </ul>
            </div>
            <a href="#!" class="modal-close">×</a>
        </div>
    </div>
    @endif
</main>
</body>
</html>