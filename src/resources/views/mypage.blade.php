@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
@endsection

@section('content')
    @if (session('success'))
        <div class="flash-message__success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="flash-message__success">{{ session('error') }}</div>
    @endif
    <div class="mypage__content">
        <div class="mypage__heading">
            @auth
            <h2>{{Auth::user()->name}}さん</h2>
            @endauth
        </div>
    </div>
    <div class="container">
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
                <a href="{{ route('reviews.create', $reservation->shop->id) }}" class="reservation-form-button">お店を評価する</a>
                <div class="qr-code">
                {!! QrCode::size(200)->generate(route('reservation.store', ['id' => $reservation->id])) !!}
                </div>
                <a href="/payment" class="payment-button">支払いをする</a>
            </div>
            @endforeach
        </div>
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
<script>
</script>
@endsection