<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Atte</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
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
        <div class="header__logo">
            Rese
        </div>
</header>
<main>
    @if (session('success'))
        <div class="flash-message__success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="flash-message__success">
            {{ session('error') }}
        </div>
    @endif
    <div class="mypage__content">
        <div class="mypage__heading">
            @auth
            <h2>{{Auth::user()->name}}さん</h2>
            @endauth
        </div>
    </div>
<div class="container">
    <!-- 左側の予約情報表示 -->
    <div class="reservation-form">
        <h2 class="reservation-form-ttl">予約状況</h2>
        @foreach ($reservations as $reservation)
        <div class="card">
            <div class="card-header">
                <h2><i class="far fa-clock xl"></i> 予約{{ $loop->iteration }}</h2>
                <form action="{{ route('reservation.destroy', $reservation->id) }}" class="reservation-delete-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="close-btn-reservation">&times;</button>
                </form>
            </div>
            <!-- 予約情報のテーブル -->
            <table class="reservation-form-table">
                <tr>
                    <th>Shop</th>
                    <td>{{ $reservation->shop->name }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $reservation->date }}</td>
                </tr>
                <tr>
                    <th>Time</th>
                    <td>{{ $reservation->time }}</td>
                </tr>
                <tr>
                    <th>Number</th>
                    <td>{{ $reservation->number }}人</td>
                </tr>
            </table>
            <a href="{{ route('reservations.edit', $reservation->id) }}" class="reservation-form-button">予約を変更する</a>
        </div>
        @endforeach
    </div>
    <!-- 右側のお気に入り店舗表示 -->
    <div class="favorite-index">
        <h2 class="favorite-ttl">お気に入り店舗</h2>
        <div class="object-container">
            @foreach($favorites as $favorite)
                <div class="object">
                    <img src="{{ $favorite->shop->image_path }}" class="object-img-top" alt="店舗画像">
                    <div class="object-body">
                        <h5 class="object-title">{{ $favorite->shop->name }}</h5>
                        <div class="tags">
                            <span class="tag">#{{ $favorite->shop->area->name }}</span>
                            <span class="tag">#{{ $favorite->shop->genre->name }}</span>
                        </div>
                        <div class="object-item">
                            <a href="{{ route('shop.detail', $favorite->shop->id) }}" class="btn-details">詳しくみる</a>
                            <form action="{{ route('mypage.delete') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="shop_id" value="{{ $favorite->shop->id }}">
                                <button class="btn-favorite" type="submit">
                                    <i class="fa-solid fa-heart fa-2x" style="color: #ff0000;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- モーダルウィンドウ -->
@if(auth()->check())
    <div class="modal-wrapper" id="modal-02">
    <a href="#!" class="modal-overlay"></a>
        <div class="modal-window">
            <div class="modal-content">
            <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="{{ route('logout') }}">Logout</a></li>
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Logout') }}
                    </x-responsive-nav-link>
                    </form>
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
</div>
</main>
</body>
</html>