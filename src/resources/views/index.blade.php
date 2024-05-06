<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Atte</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
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
    <div class="search__form">
        <form class="search-form" action="/search" method="get">
       @csrf
       <div class="search-form__area">
        <select class="search-form__area-select" name="area_id" >
          <option disabled selected>All area</option>
          @foreach($areas as $area)
          <option value="{{ $area->id }}" @if( request('area_id')==$area->id ) selected @endif
            >{{$area->name }}
          </option>
          @endforeach
        </select>
      </div>
      <div class="search-form__genre">
        <select class="search-form__genre-select" name="genre_id">
          <option disabled selected>All genre</option>
          @foreach($genres as $genre)
          <option value="{{ $genre->id }}" @if( request('genre_id')==$genre->id ) selected @endif
            >{{$genre->name }}
          </option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="search-form__submit-button">
      <i class="fas fa-search"></i>
      </button>
      <input class="search-form__keyword-input" type="text" name="keyword" placeholder="Search ..." type="submit"
        value="{{request('keyword')}}">
      <div class="search-form__actions">
        <input class="search-form__search-btn btn" type="submit" value="検索">
        <input class="search-form__reset-btn btn" type="submit" value="リセット" name="reset">
      </div>
    </form>
</div>

  </header>
  <main>
<div class="container">
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
</main>
</body>
</html>