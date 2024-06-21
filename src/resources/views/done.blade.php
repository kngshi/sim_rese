@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/done.css') }}" />
@endsection

@section('content')
  <div class="done-page">
    <div class="done-page__inner">
      <p class="done-page__message">ご予約ありがとうございます</p>
      <a href="{{ route('detail', ['shop' => $shop_id]) }}" class="done-page__btn">戻る</a>
    </div>
  </div>
@endsection
