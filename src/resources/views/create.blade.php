@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/review.css') }}" />
@endsection

@section('content')
@if (session('success'))
    <div class="flash-message__success">{{ session('success') }}</div>
@endif
<div class="container">
    <!-- 左側の店舗詳細情報 -->
    <div class="shop-details">
        <div class="object-header">
            <a href="/mypage" class="back-button">&lt;</a>
            <h2>{{ $shop->name }}</h2>
        </div>
        <img src="{{ $shop->image_path }}" alt="店舗画像">
        <div class="tags">
            <span class="tag">#{{ $shop->area->name }}</span>
            <span class="tag">#{{ $shop->genre->name }}</span>
        </div>
        <p class="description">{{ $shop->description }}</p>
        <div class="review-list">
            <h3 class="review-ttl">お店の評価</h3>
            @forelse ($reviews as $review)
                <div class="review">
                    <p><strong>{{ $review->rating_text}}</strong>  ({{ $review->created_at }})</p>
                    <p>{{ $review->comment }}</p>
                </div>
            @empty
                <p>まだレビューはありません。</p>
            @endforelse
        </div>
    </div>

    <!-- 右側の評価フォーム -->
    <div class="reservation-form">
    <h2>{{ $shop->name }} を評価する</h2>
    <form action="{{ route('reviews.store') }}" method="POST">
        @csrf
        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
        <div>
            <label for="rating">評価:</label>
            <select id="rating" name="rating" required>
                    <option value="">-- 選択してください --</option>
                    <option value="5">5:非常に良い</option>
                    <option value="4">4:良い</option>
                    <option value="3">3:普通</option>
                    <option value="2">2:不満</option>
                    <option value="1">1:非常に不満</option>
                </select>
            @error('rating')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div class="comment">
            <label for="comment">コメント:</label>
            <textarea id="comment" name="comment" rows="5"></textarea>
            @error('comment')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <button type="submit">投稿する</button>
    </form>
    </div>
</div>
@endsection
