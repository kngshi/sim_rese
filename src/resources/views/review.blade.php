@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/components/header.css') }}" />
<link rel="stylesheet" href="{{ asset('css/review.css') }}" />
@endsection

@section('content')
@if (session('success'))
<div class="flash-message__success">{{ session('success') }}</div>
@endif
@if ($errors->has('review'))
<div class="alert alert-danger">
    {{ $errors->first('review') }}
</div>
@endif
<div class="container">
    <div class="shop-details">
        <div class="object-header">
            <h2>今回のご利用はいかがでしたか？</h2>
        </div>
        <div class="object">
            <img src="{{ $shop->image_path }}" class="object-img-top" alt="店舗画像">
            <div class="object-body">
                <h5 class="object-title">{{ $shop->name }}</h5>
                <div class="tags">
                    <span class="tag">#{{ $shop->area->name }}</span>
                    <span class="tag">#{{ $shop->genre->name }}</span>
                </div>
                <div class="object-item">
                    <a href="{{ route('detail', $shop->id) }}" class="btn-details">詳しくみる</a>
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
    </div>
    <div class="review-form">
        <form action="{{ isset($review) ? route('reviews.update', $review->id) : route('reviews.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($review))
            @method('PUT')
            @endif
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <div class="review-rating">
                <label for="rating">体験を評価してください</label>
                @error('rating')
                <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="star-rating">
                    <input type="hidden" id="rating" name="rating" value="{{ old('rating', isset($review) ? $review->rating : '') }}">
                    <i class="fa fa-star fa-2x" data-value="1"></i>
                    <i class="fa fa-star fa-2x" data-value="2"></i>
                    <i class="fa fa-star fa-2x" data-value="3"></i>
                    <i class="fa fa-star fa-2x" data-value="4"></i>
                    <i class="fa fa-star fa-2x" data-value="5"></i>
                </div>
            </div>
            <div class="comment">
                <label for="comment">口コミを投稿</label>
                @error('comment')
                <div class="error-message"> {{ $message }}</div>
                @enderror
                <textarea id="comment" name="comment" placeholder="カジュアルな夜のお出かけにおすすめのスポット">{{ old('comment', isset($review) ? $review->comment : '') }}</textarea>
                <div class="letter-count">0/400(最高文字数)</div>
            </div>
            <div class="img-upload">
                <label for="img_url">画像の追加</label>
                @error('img_url')
                <div class="error-message"> {{ $message }}</div>
                @enderror
                <div class="img-input_form">
                    <input type="file" id="img_url" name="img_url" accept="image/*" style="display:none;">
                    <span class="upload-text">クリックして写真を追加<br>またはドラッグアンドドロップ</span>
                    <div class="img-preview" id="img-preview"></div>
                </div>
            </div>
            <div class="review-button">
                <button type="submit" class="post-review">{{ isset($review) ? '口コミを更新' : '口コミを投稿' }}</button>
            </div>
        </form>
    </div>
</div>
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

    document.addEventListener('DOMContentLoaded', function() {
        const commentInput = document.getElementById('comment');
        const letterCountDisplay = document.querySelector('.letter-count');
        const maxLength = 400;

        commentInput.addEventListener('input', function() {
            const currentLength = commentInput.value.length;
            letterCountDisplay.textContent = `${currentLength}/${maxLength}(最高文字数)`;
        });
    });

    const fileInput = document.getElementById('img_url');
    const imgInputForm = document.querySelector('.img-input_form');
    const preview = document.getElementById('img-preview');

    imgInputForm.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        handleFileUpload(file);
    });

    imgInputForm.addEventListener('dragover', (e) => {
        e.preventDefault();
        imgInputForm.classList.add('dragover');
    });

    imgInputForm.addEventListener('dragleave', () => {
        imgInputForm.classList.remove('dragover');
    });

    imgInputForm.addEventListener('drop', (e) => {
        e.preventDefault();
        imgInputForm.classList.remove('dragover');

        const file = e.dataTransfer.files[0];
        handleFileUpload(file);
    });

    function handleFileUpload(file) {
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="画像プレビュー">`;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection