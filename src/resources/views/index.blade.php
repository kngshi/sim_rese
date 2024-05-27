
@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('search-form')
  <div class="search__form">
    <form class="search-form" action="/search" method="get">
    @csrf
      <div class="search-form__area">
        <select class="search-form__area-select" name="area_id" onchange="this.form.submit()">
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
    </form>
  </div>
@endsection

@section('content')
  @if (session('create'))
    <div class="flash-message__create">{{ session('create') }}</div>
  @endif
  @if (session('delete'))
    <div class="flash-message__delete">{{ session('delete') }}</div>
  @endif
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
                <a href="{{ route('shop.detail', $shop->id) }}" class="btn-details">詳しくみる</a>
                @if(Auth::check() && Auth::user()->favorites()->where('shop_id', $shop->id)->exists())
                <form action="{{ route('favorites.delete') }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                  <button class="btn-favorite" type="submit">
                      <i class="fa-solid fa-heart fa-2x" style="color: #ff0000;"></i>
                  </button>
                </form>
                @else
                <form action="{{ route('favorite.addFavorite') }}" method="POST">
                  @csrf
                  <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                  <button class="btn-favorite" type="submit">
                      <i class="far fa-heart fa-2x"></i>
                  </button>
                </form>
                @endif
              </div>
            </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
