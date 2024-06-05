@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/detail.css') }}" />
@endsection

@section('content')
<div class="container">
    <!-- 左側の店舗詳細情報 -->
    <div class="shop-details">
        <div class="object-header">
            <a href="/" class="back-button">&lt;</a>
            <h2>{{ $shop->name }}</h2>
        </div>
        <img src="{{ $shop->image_path }}" alt="店舗画像">
        <div class="tags">
            <span class="tag">#{{ $shop->area->name }}</span>
            <span class="tag">#{{ $shop->genre->name }}</span>
        </div>
        <p class="description">{{ $shop->description }}</p>
    </div>

    <!-- 右側の予約フォーム -->
    <div class="reservation-form">
        <h2>予約</h2>
        <form action="{{ route('reservation.store') }}" method="POST">
            @csrf
            <input type="date" id="date" name="date" required>
            @error('date')
                {{ $message }} 
            @enderror
            <select id="time" name="time" required>
                <!-- ここに時刻の選択肢を追加 -->
            <option value="">-- 選択してください --</option>
            @for ($hour = 12; $hour <= 15; $hour++)
            <option value="{{ sprintf('%02d', $hour) }}:00">{{ sprintf('%02d', $hour) }}:00</option>
            <option value="{{ sprintf('%02d', $hour) }}:30">{{ sprintf('%02d', $hour) }}:30</option>
            @endfor
            @for ($hour = 17; $hour <= 23; $hour++)
            <option value="{{ sprintf('%02d', $hour) }}:00">{{ sprintf('%02d', $hour) }}:00</option>
            <option value="{{ sprintf('%02d', $hour) }}:30">{{ sprintf('%02d', $hour) }}:30</option>
            @endfor
            </select>
            @error('time')
                {{ $message }}
            @enderror

            <select id="number" name="number" required>
                <!-- ここに人数の選択肢を追加 -->
            <option value="">-- 選択してください --</option>
            @for ($i = 1; $i <= 10; $i++)
            <option value="{{ $i }}">{{ $i }}人</option>
            @endfor
            </select>
            @error('number')
                {{ $message }} 
            @enderror

        <!-- 予約情報のテーブル -->
        <table class="reservation-form-table">
            <tr>
                <th>Shop</th>
                <td>{{ $shop->name }}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td id="reservation-date"></td>
            </tr>
            <tr>
                <th>Time</th>
                <td id="reservation-time"></td>
            </tr>
            <tr>
                <th>Number</th>
                <td id="reservation-number"></td>
            </tr>
        </table>
        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <button type="submit">予約する</button>
        </form>
    </div>
</div>
</div>

 <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // DOMの読み込みが完了したらここにJavaScriptの処理を記述する
            document.getElementById('date').addEventListener('change', function() {
                document.getElementById('reservation-date').innerText = this.value;
            });

            document.getElementById('time').addEventListener('change', function() {
                document.getElementById('reservation-time').innerText = this.value;
            });

            document.getElementById('number').addEventListener('change', function() {
                document.getElementById('reservation-number').innerText = this.options[this.selectedIndex].text;
            });
        });
    </script>
@endsection