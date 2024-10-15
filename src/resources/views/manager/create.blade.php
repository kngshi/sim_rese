@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/components/header.css') }}" />
<link rel="stylesheet" href="{{ asset('css/manager/create.css') }}" />
@endsection

@section('content')
@if (session('success'))
<div class="alert-success">
    {{ session('success') }}
</div>
@endif
@if (session('error'))
<div class="alert-danger">
    {{ session('error') }}
</div>
@endif
<div class="container">
    <div class="shop-create-form">
        <h2>店舗情報の作成</h2>
        <form action="{{ route('shop.create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="form-group">
                <label for="name">店舗名</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="店名を入力してください。" autocomplete="name">
            </div>
            <div class="form-group">
                <label for="area_id">地域</label>
                <select name="area_id" id="area_id" class="form-control" autocomplete="off">
                    <option value="" disabled selected>選択してください</option>
                    @foreach ($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="genre_id">ジャンル</label>
                <select name="genre_id" id="genre_id" class="form-control" autocomplete="off">
                    <option value="" disabled selected>選択してください</option>
                    @foreach ($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">店舗概要</label>
                <textarea name="description" id="description" class="form-control" placeholder="店舗の概要を400字以内で入力してください。" autocomplete="off"></textarea>
            </div>
            <div class="form-group">
                <label for="image">画像</label>
                <input type="file" name="image" id="image" class="form-control" autocomplete="off">
            </div>
            <button type="submit" class="button">作成</button>
        </form>
        <a href="/manager/dashboard" class="back-link">戻る</a>

    </div>
</div>
@endsection