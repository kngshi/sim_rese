@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/components/header.css') }}" />
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}" />
@endsection

@section('content')
<div class="container">
    <h1>管理者ダッシュボード</h1>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="dashboard-sections">
        <div class="dashboard-section">
            <h2>店舗代表者の作成</h2>
            <a href="/admin/create" class="btn-primary">店舗代表者作成フォーム</a>
        </div>
        <div class="dashboard-section">
            <h2>お知らせメールの送信</h2>
            <a href="/admin/notify" class="btn-primary">メール送信フォーム</a>
        </div>
        <div class="dashboard-section">
            <h2>新規店舗の作成</h2>
            <a href="{{ route('admin.csv.import') }}" class="btn-primary">CSVファイルのインポート</a>
        </div>
    </div>
</div>
@endsection