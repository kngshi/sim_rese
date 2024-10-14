@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/components/header.css') }}" />
<link rel="stylesheet" href="{{ asset('css/reviews/review-index.css') }}" />
@endsection

@section('content')
<div class="shop-details">
    <h2>{{ $shop->name }} の口コミ一覧</h2>

    <div class="review-list">
        @foreach ($reviews as $review)
        <div class="review-card">
            @if (Auth::check() && Auth::id() == $review->user_id)
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
            @elseif (Auth::check() && Auth::user()->role == 1)
            <div class="review-link__group">
                <form action="{{ route('reviews.destroy', ['review' => $review->id]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="review-link__button">口コミを削除</button>
                </form>
            </div>
            @endif
            <p class="user-name">{{ $review->user->name }}</p>
            <p class="rating">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fa fa-star {{ $i <= $review->rating ? 'selected' : '' }}"></i>
                    @endfor
            </p>
            <p class="comment">{{ $review->comment }}</p>
            @if ($review->img_url)
            <div class="review-image">
                <img src="{{ Storage::url($review->img_url) }}" alt="口コミ画像" class="review-img">
            </div>
            @endif
        </div>
        @endforeach
    </div>
    <div class="back-button-wrapper">
        <a href="{{ url()->previous() }}" class="back-button">戻る</a>
    </div>
</div>
@endsection
<script>
    const stars = document.querySelectorAll('.star-rating i');
    const ratingInput = document.getElementById('rating');

    const oldRating = "{{ old('rating', isset($review) ? $review->rating : '') }}";

    if (oldRating) {
        stars.forEach(star => {
            if (star.getAttribute('data-value') <= oldRating) {
                star.classList.add('selected');
            }
        });
        ratingInput.value = oldRating;
    }

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-value');
            ratingInput.value = rating;

            stars.forEach(s => {
                s.classList.remove('selected');
                if (s.getAttribute('data-value') <= rating) {
                    s.classList.add('selected');
                }
            });
        });
    });
</script>