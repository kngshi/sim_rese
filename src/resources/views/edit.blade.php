@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/components/header.css') }}" />
<link rel="stylesheet" href="{{ asset('css/edit.css') }}" />
@endsection

@section('content')
<div class="container">
    <div class="reservation-info">
        <div class="reservation-info-header">
            <h2><i class="far fa-clock xl"></i> 予約詳細</h2>
            <form action="{{ route('reservation.destroy', $reservation->id) }}" class="reservation-delete-form" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="close-btn-reservation">&times;</button>
            </form>
        </div>
        <table class="reservation-info-table">
            <tr>
                <th>Shop</th>
                <td>{{ $reservation->shop->name }}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ $reservation->date }}</td>
            </tr>
            <tr>
                <th>Time</th>
                <td>{{ $reservation->time }}</td>
            </tr>
            <tr>
                <th>Number</th>
                <td>{{ $reservation->number }}人</td>
            </tr>
        </table>
        <a href="/mypage" class="return">マイページに戻る</a>
    </div>
    <div class="reservation-form">
        <h2>予約内容の変更</h2>
        <div class="reservation-form-shop">Shop {{ $reservation->shop->name }}</div>
        <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="date" id="date" name="date" value="{{ $reservation->date }}" required>
            @error('date')
            {{ $message }}
            @enderror
            <select id="time" name="time" required>
                <option value="">-- 選択してください --</option>
                @foreach($times as $time)
                <option value="{{ $time }}" @if($reservation->time == $time) selected @endif>{{ $time }}</option>
                @endforeach
            </select>
            @error('time')
            {{ $message }}
            @enderror
            <select id="number" name="number" required>
                <option value="">-- 選択してください --</option>
                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" @if($reservation->number == $i) selected @endif>{{ $i }}人</option>
                    @endfor
            </select>
            @error('number')
            {{ $message }}
            @enderror
            <input type="hidden" name="shop_id" value="{{ $reservation->shop_id }}">
            <button type="submit">予約を変更する</button>
        </form>
    </div>
</div>
</div>
@endsection