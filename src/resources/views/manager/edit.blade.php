

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/manager/edit.css') }}" />
@endsection

@section('content')
@if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
@endif
@if ($shop)
<div class="container">
    <div class="shop-details">
        <div class="object-@extends('layouts.common')header">
            <a href="/manager/dashboard" class="back-button">&lt;</a>
            <h2>{{ $shop->name }}</h2>
        </div>
        <img src="{{ $shop->image_path }}" alt="店舗画像">
        <div class="tags">
            <span class="tag">#{{ $shop->area->name }}</span>
            <span class="tag">#{{ $shop->genre->name }}</span>
        </div>
        <p class="description">{{ $shop->description }}</p>
    </div>
    <div class="update-form">
    <h2>店舗情報の更新</h2>
    <form action="{{ route('manager.update') }}" method="POST">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="name">店舗名</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $shop->name }}" required>
        </div>
        <div class="form-group">
            <label for="area_id">エリア</label>
                <select name="area_id" id="area_id" class="form-control" required>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ $shop->area_id == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                    @endforeach
                </select>
        </div>
        <div class="form-group">
            <label for="genre_id">ジャンル</label>
                <select name="genre_id" id="genre_id" class="form-control" required>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ $shop->genre_id == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                    @endforeach
                </select>
        </div>
        <div class="form-group">
            <label for="description">説明</label>
            <textarea name="description" id="description" class="form-control" required>{{ $shop->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="image_path">画像パス</label>
            <input type="text" name="image_path" id="image_path" class="form-control" value="{{ $shop->image_path }}">
        </div>
        <button type="submit" class="btn btn-primary">更新</button>
    </form>
    </div>
</div>
@else
    <p class="shop-message">{{ $message }}</p>
    <a href="/manager/dashboard" class="back">戻る</a>
@endif
@endsection