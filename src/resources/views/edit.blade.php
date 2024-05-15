<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Atte</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/edit.css') }}" />
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
    </div>
  </header>
  <main>
<div class="container">
        <!-- 左側の予約情報表示 -->
            <div class="reservation-info">
                <div class="reservation-info-card-header">
                    <div class="reservation-info-card-item">
                        <h2><i class="far fa-clock xl"></i> 予約詳細</h2>
                        <form action="{{ route('reservation.destroy', $reservation->id) }}" class="reservation-delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="close-btn-reservation">&times;</button>
                        </form>
                    </div>
                </div>
                    <table class="reservation-info-table">
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
                    <a href="/mypage" class="return">マイページに戻る</a>
            </div>


    <!-- 右側の予約フォーム -->
    <div class="reservation-form">
                <h2>予約の変更</h2>
                <div class="reservation-form-shop">Shop {{ $reservation->shop->name }}</div>
                <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="date" id="date" name="date" value="{{ $reservation->date }}" required>

                    <select id="time" name="time" required>
                        <option value="">-- 選択してください --</option>
                        @foreach($times as $time)
                            <option value="{{ $time }}" @if($reservation->time == $time) selected @endif>{{ $time }}</option>
                        @endforeach
                    </select>

                    <select id="number" name="number" required>
                        <option value="">-- 選択してください --</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" @if($reservation->number == $i) selected @endif>{{ $i }}人</option>
                        @endfor
                    </select>
                    
                    <input type="hidden" name="shop_id" value="{{ $reservation->shop_id }}">
                    <button type="submit">予約を変更する</button>
                </form>
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
</main>
</body>
</html>