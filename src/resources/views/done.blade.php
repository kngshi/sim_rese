<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rese</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/done.css') }}" />
</head>
<body>
<header class="header">
        <div class="header__inner">
            <div class="openbtn6"><span></span><span></span><span></span></div>
            <div class="header__logo">Rese</div>
        </div>
    </header>
<main>
<div class="done-page">
  <div class="done-page__inner">
    <p class="done-page__message">ご予約ありがとうございます</p>
    <form class="done-page__form" action="/" method="get">
        <button class="done-page__btn btn">戻る</button>
    </form>
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