<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Shop;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


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
            'user_id' => $userId,
            'shop_id' => $request->input('shop_id'),
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'number' => $request->input('number'),
            'status' => 1,
        ];

        // 予約情報を保存
        $reservation = Reservation::create($reservationData);


        // 予約が成功した場合、QRコードを生成して保存
        if ($reservation) {

            $qrUrl = route('reservation.store', ['id' => $reservation->id]);
            $qrCode = QrCode::size(200)->generate($qrUrl);

            // セッションにQRコードを保存してからリダイレクト
            session()->flash('qrCode', $qrCode);
            session()->flash('shop_id', $reservation->shop_id);

            return redirect()->route('done');
        } else {
            return redirect()->back()->with('error', '予約に失敗しました。');
        }
    }

    public function done(Request $request)
    {
        $shop_id = $request->query('shop_id');
        $qrCode = $request->query('qrCode');

        $qrCode = session('qrCode');
        $shop_id = session('shop_id');

        return view('done', compact('shop_id', 'qrCode'));
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

        if ($reservation->user_id !== $user->id) {
            return redirect()->route('mypage.mypageIndex')->with('error', '不正なアクセスです。');
        }

        $times = [];
        for ($hour = 12; $hour <= 15; $hour++) {
            $times[] = sprintf('%02d:00', $hour);
            $times[] = sprintf('%02d:30', $hour);
        }
        for ($hour = 17; $hour <= 23; $hour++) {
            $times[] = sprintf('%02d:00', $hour);
            $times[] = sprintf('%02d:00', $hour);
        }

        $reservation->time = Carbon::createFromFormat('H:i:s', $reservation->time)->format('H:i');

        return view('edit', compact('reservation', 'times'));
    }

    public function update(ReservationRequest $request, Reservation $reservation)
    {
        $request->validate([
            'date' => 'required',
            'time' => 'required',
            'number' => 'required|numeric|min:1|max:10',
        ]);

        $user = Auth::user();
        if ($reservation->user_id !== $user->id) {
            return redirect()->route('mypage.mypageIndex')->with('error', '不正なアクセスです。');
        }

        $reservation->update($request->only('date', 'time', 'number'));

        return redirect()->route('mypage.mypageIndex')->with('success', '予約情報を更新しました。');
    }
}
