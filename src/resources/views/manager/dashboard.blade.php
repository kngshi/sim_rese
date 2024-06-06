@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/manager/dashboard.css') }}" />
@endsection

@section('content')
    <h1>店舗責任者用ダッシュボード</h1>
    <h2>店舗管理</h2>
    <div class="dashboard-sections">
        <div class="dashboard-section">
            <a href="/manager/create" class="link" >店舗情報の作成</a>
            <a href="/manager/edit" class="link" >店舗情報の更新</a>
        </div>
    </div>
    <h2>予約管理</h2>
    <div class="dashboard-sections">
        <div class="dashboard-section">
            <a href="/manager/index" class="link">予約情報の確認</a>
            <a href="/manager/notify" class="link">お知らせメールの送信</a>
        </div>
    </div>
@endsection
