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
    <form class="done-page__form" action="/mypage" method="post">
        <button class="done-page__btn btn">戻る</button>
    </form>
  </div>
</div>
</main>
</body>
</html>