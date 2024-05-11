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
        <a href="#modal-01">
            <div class="openbtn6"><span></span><span></span><span></span></div>
        </a>
        <div class="header__logo">
            Rese
        </div>
  </header>
  <main>
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
        <h2>予約状況</h2>
        <!-- 予約情報のテーブル -->
        <table class="reservation-form-table">
            <tr>
                <th>Shop</th>
                <td>店舗名</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>2024-05-05</td>
            </tr>
            <tr>
                <th>Time</th>
                <td>17:00</td>
            </tr>
            <tr>
                <th>Number</th>
                <td>1人</td>
            </tr>
        </table>
    </div>
     <!-- 右側のお気に入り店舗表示 -->
    <div class="favorite-index">
        <h2 class="favorite-ttl">お気に入り店舗</h2>
    <div class="object-container">
          @foreach($shops as $shop)
            <div class="object">
                <img src="{{ $shop->image_path }}" class="object-img-top" alt="店舗画像">
                <div class="object-body">
                    <h5 class="object-title">{{ $shop->name }}</h5>
                    <div class="tags">
                        <span class="tag">#{{ $shop->area->name }}</span>
                        <span class="tag">#{{ $shop->genre->name }}</span>
                    </div>
                    <div class="object-item">
                    <a href="{{ route('shop.detail', $shop->id) }}" class="btn-details">詳しくみる</a><button class="btn-favorite" data-shop-id="{{ $shop->id }}">
                    <i class="far fa-heart fa-2x"></i>
                    </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</div>
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
</main>
</body>
</html>