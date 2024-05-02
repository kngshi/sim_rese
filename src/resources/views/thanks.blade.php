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
    <body>
    <header class="header">
        <div class="header__inner">
            <div class="openbtn6"><span></span><span></span><span></span></div>
            <div class="header__logo">Rese</div>
        </div>
    </header>
    <main>
        <div class="thanks-page">
        <div class="thanks-page__inner">
            <p class="thanks-page__message">会員登録ありがとうございます</p>
            <form class="thanks-page__form" action="/login" method="get">
            <button class="thanks-page__btn btn">ログインする</button>
            </form>
        </div>
        </div>
    </main>
    </body>
</html>