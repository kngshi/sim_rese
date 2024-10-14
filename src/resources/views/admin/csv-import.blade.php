@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/admin/csv-import.css') }}" />
@endsection

@section('content')
<div class="container">
    <div class="title">
        <h1>CSVインポート</h1>
    </div>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('admin.csv.import.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="csv_file">CSVファイルを選択してください</label>
            <input type="file" class="form-control" name="csv_file" id="csv_file" required>
        </div>
        <div class="button-wrapper">
            <button type="submit" class="btn btn-primary">インポート</button>
        </div>
    </form>
    <div class="back-link-wrapper">
        <a href="{{ url()->previous() }}" class="back-link">戻る</a>
    </div>
</div>
@endsection