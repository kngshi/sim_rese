<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store(ReservationRequest $request)
    {
        // バリデーション
        $request->validate([
            'date' => 'required',
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

    public function destroy($id)
    {
        $reservation = Reservation::find($id);

        if ($reservation && $reservation->user_id == Auth::id()) {
            $reservation->delete();
            return redirect()->route('mypage.mypageIndex')->with('success', '予約が削除されました。');
        }

        return redirect()->route('mypage.mypageIndex')->with('error', '予約の削除に失敗しました。');
    }

    public function edit(Reservation $reservation)
    {
        $user = Auth::user();

        // ログインユーザーの予約であることを確認
        if ($reservation->user_id !== $user->id) {
            return redirect()->route('mypage.mypageIndex')->with('error', '不正なアクセスです。');
        }

        // 時間の選択肢を生成
        $times = [];
        for ($hour = 12; $hour <= 15; $hour++) {
            $times[] = sprintf('%02d:00:00', $hour);
            $times[] = sprintf('%02d:30:00', $hour);
        }
        for ($hour = 17; $hour <= 23; $hour++) {
            $times[] = sprintf('%02d:00:00', $hour);
            $times[] = sprintf('%02d:00:00', $hour);
        }

        return view('edit', compact('reservation', 'times'));
    }

    // 予約情報更新
    public function update(ReservationRequest $request, Reservation $reservation)
    {
        // バリデーション
        $request->validate([
            'date' => 'required',
            'time' => 'required',
            'number' => 'required|numeric|min:1|max:10',
        ]);

        // ログインユーザーの予約であることを確認
        $user = Auth::user();
        if ($reservation->user_id !== $user->id) {
            return redirect()->route('mypage.mypageIndex')->with('error', '不正なアクセスです。');
        }

        // 予約情報を更新
        $reservation->update($request->only('date', 'time', 'number'));

        return redirect()->route('mypage.mypageIndex')->with('success', '予約情報を更新しました。');
    }

}
