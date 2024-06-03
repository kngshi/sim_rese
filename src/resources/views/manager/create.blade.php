@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/manager/create.css') }}" />
@endsection


@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1>店舗情報の作成</h1>
    <form action="{{ route('shop.create') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">店舗名</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="area_id">エリアID</label>
            <input type="text" name="area_id" id="area_id" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="genre_id">ジャンルID</label>
            <input type="text" name="genre_id" id="genre_id" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">説明</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="image_path">画像パス</label>
            <input type="text" name="image_path" id="image_path" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary" >作成</button>
    </form>
</div>
@endsection