@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
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
            <a href="/admin/create" class="btn-primary" >店舗代表者の一覧と作成</a>
        </div>
        <div class="dashboard-section">
            <h2>店舗管理</h2>
            <a href="/manager/create" class="btn-primary">店舗情報の作成と更新</a>
        </div>
    </div>
    <a href="/admin/notify" class="">お知らせメールの送信</a>
    </div>
@endsection

