@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/detail.css') }}" />
@endsection

@section('content')
    <div class="container">
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
            <div class="review-list">
                <h3 class="review-ttl">お店の評価</h3>
                @forelse ($reviews as $review)
                    <div class="review">
                        <p><strong>{{ $review->rating_text}}</strong>  ({{ $review->created_at }})</p>
                        <p>{{ $review->comment }}</p>
                    </div>
                @empty
                    <p>まだレビューはありません。</p>
                @endforelse
            </div>
        </div>
        <div class="reservation-form">
            <h2>予約</h2>
            <form action="{{ route('reservation.store') }}" method="POST">
                @csrf
                <input type="date" id="date" name="date" required>
                @error('date')
                    {{ $message }}
                @enderror
                <select id="time" name="time" required>
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
                    <option value="">-- 選択してください --</option>
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }}人</option>
                    @endfor
                </select>
                @error('number')
                    {{ $message }}
                @enderror
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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