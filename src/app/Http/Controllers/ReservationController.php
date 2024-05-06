<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'number' => 'required|numeric|min:1|max:10',
        ]);

        // ログインユーザーのIDを取得
        $userId = Auth::id();


        // リクエストデータから予約情報を取得
        $reservationData = [
            'user_id' => $userId, // ログインユーザーのID
            'shop_id' => $request->input('shop_id'), // 予約した店舗のID
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'number' => $request->input('number'),
            // その他必要な情報があれば追加
        ];

        // 予約情報を保存
        $reservation = Reservation::create($reservationData);

        // 予約が成功した場合の処理
        if ($reservation) {
            return view('/done');
        } else {
            return redirect()->back()->with('error', '予約に失敗しました。');
        }
    }

}
