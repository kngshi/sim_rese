@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/detail.css') }}" />
@endsection

@section('content')
@if (session('success'))
<div class="flash-message__success">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="flash-message__success">{{ session('error') }}</div>
@endif
@if (session('message'))
<div class="alert alert-success">{{ session('message') }}</div>
@endif
<div class="container">
    <div class="shop-details">
        @if (!isset($existingReview))
        <div class="object-header">
            <a href="/" class="back-button">&lt;</a>
            <h2>{{ $shop->name }}</h2>
        </div>
        @endif
        <img src="{{ $shop->image_path }}" alt="店舗画像" class="{{ isset($existingReview) ? 'small-image' : '' }}">
        <div class="tags">
            <span class="tag">#{{ $shop->area->name }}</span>
            <span class="tag">#{{ $shop->genre->name }}</span>
        </div>
        <p class="description">{{ $shop->description }}</p>
        @if (isset($existingReview) || (Auth::check() && (Auth::user()->role == 1 || Auth::user()->role == 2)))
        <div class="review-index">
            <form action="{{ route('reviews.index', $shop->id) }}" method="GET">
                <button type="submit" class="review-index__button">全ての口コミ情報</button>
            </form>
        </div>
        @endif
        <div class="review-list {{ $reviews->isNotEmpty() ? 'has-reviews' : '' }}">
            @if (Auth::check() && $existingReview)
            @foreach ($reviews as $review)
            @if (Auth::id() == $review->user_id)
            <div class="review">
                <div class="review-link__group">
                    <form action="{{ route('reviews.edit', $review->id) }}" method="GET">
                        <button type="submit" class="review-link__button">口コミを編集</button>
                    </form>
                    <form action="{{ route('reviews.destroy', ['review' => $review->id]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="review-link__button">口コミを削除</button>
                    </form>
                </div>
                <p class="rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star {{ $i <= $review->rating ? 'selected' : '' }}"></i>
                        @endfor
                </p>
                <p class="comment">{{ $review->comment }}</p>
            </div>
            @endif
            @endforeach
            @else
            <a href="{{ route('reviews.create', $shop->id) }}" class="btn">口コミを投稿する</a>
            @endif
        </div>
    </div>
    <div class="reservation-form">
        <h2 class="reservation-form-ttl">予約</h2>
        <form action="{{ route('reservation.store') }}" method="POST">
            @csrf
            <input type="date" id="date" name="date" required>
            @error('date')
            <div class="error-message">
                {{ $message }}
            </div>
            @enderror
            <select id="time" name="time" required>
                <option value="">-- 選択してください --</option>
                @for ($hour = 12; $hour <= 15; $hour++)
                    <option value="{{ sprintf('%02d', $hour) }}:00">{{ sprintf('%02d', $hour) }}:00</option>
                    <option value="{{ sprintf('%02d', $hour) }}:30">{{ sprintf('%02d', $hour) }}:30</option>
                    @endfor
                    @for ($hour = 17; $hour <= 23; $hour++)
                        <option value="{{ sprintf('%02d', $hour) }}:00">{{ sprintf('%02d', $hour) }}:00</option>
                        <option value="{{ sprintf('%02d', $hour) }}:30">{{ sprintf('%02d', $hour) }}:30</option>
                        @endfor
            </select>
            @error('time')
            {{ $message }}
            @enderror
            <select id="number" name="number" required>
                <option value="">-- 選択してください --</option>
                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}">{{ $i }}人</option>
                    @endfor
            </select>
            @error('number')
            {{ $message }}
            @enderror
            <table class="reservation-form-table">
                <tr>
                    <th>Shop</th>
                    <td>{{ $shop->name }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td id="reservation-date"></td>
                </tr>
                <tr>
                    <th>Time</th>
                    <td id="reservation-time"></td>
                </tr>
                <tr>
                    <th>Number</th>
                    <td id="reservation-number"></td>
                </tr>
            </table>
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <button type="submit">予約する</button>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('date').addEventListener('change', function() {
            document.getElementById('reservation-date').innerText = this.value;
        });

        document.getElementById('time').addEventListener('change', function() {
            document.getElementById('reservation-time').innerText = this.value;
        });

        document.getElementById('number').addEventListener('change', function() {
            document.getElementById('reservation-number').innerText = this.options[this.selectedIndex].text;
        });
    });
</script>
@endsection