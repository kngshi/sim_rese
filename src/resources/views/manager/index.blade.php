@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/components/header.css') }}" />
<link rel="stylesheet" href="{{ asset('css/manager/index.css') }}" />
@endsection

@section('content')
<h1 class="content-ttl">予約情報管理</h1>
<div class="date-navigation">
    <a href="{{ route('reservation.index', ['date' => $previousDate]) }}" class="date-tag">&lt;</a>
    <span class="current-date">{{ $date }}</span>
    <a href="{{ route('reservation.index', ['date' => $nextDate]) }}" class="date-tag">&gt;</a>
</div>
@if ($reservations->isEmpty())
<p class="reservation-empty">予約が見つかりません。</p>
@else
<div class="reservations-table">
    <table>
        <tr>
            <th>ユーザー名</th>
            <th>時間</th>
            <th>人数</th>
        </tr>
        @foreach ($reservations as $reservation)
        <tr>
            <td>{{ $reservation->user->name }}</td>
            <td>{{ $reservation->time }}</td>
            <td>{{ $reservation->number }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endif
<a href="/manager/dashboard" class="back">戻る</a>
@endsection