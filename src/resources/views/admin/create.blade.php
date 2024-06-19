@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/admin/create.css') }}" />
@endsection


@section('content')
<h1>店舗代表者作成ページ</h1>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="shop-managers">
    <div class="shop-managers-section">
    <h2>店舗代表者一覧</h2>
    @if ($shopManagers->isEmpty())
        <p>店舗代表者が見つかりません。</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>メールアドレス</th>
                    <th>所属店舗</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shopManagers as $shopManager)
                    <tr>
                        <td>{{ $shopManager->name }}</td>
                        <td>{{ $shopManager->email }}</td>
                        <td>
                        @if ($shopManager->shop_id)
                            {{ \App\Models\Shop::findOrFail($shopManager->shop_id)->name }}
                        @else
                            未割り当て
                        @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a href="/admin/dashboard" class="back-link" >戻る</a>
    </div>
    <div class="shop-managers-section">
    <h2>店舗代表者の登録</h2>
        <form action="{{ route('admin.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">名前</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Eメール</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-group">
            <input type="hidden" name="role" value="2">
            </div>
            <button type="submit" class="create-form-button">作成</button>
        </form>
    </div>
</div>
@endsection
