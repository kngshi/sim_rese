<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use App\Notifications\UserNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class AdminController extends Controller
{
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function createManager(Request $request)
    {
        $shopManagers = User::where('role', 2)->get();

        return view('admin.create', compact('shopManagers'));
    }

    public function storeManager(AdminRequest $request)
    {
        $shopManagers = User::where('role', 2)->get();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => '2',
            'password' => Hash::make($request->password),
        ]);

        return view('admin.create', compact('user','shopManagers'))->with('success', '店舗代表者を作成しました。');
    }


    public function managerDashboard()
    {
        return view('manager.dashboard');
    }

    public function shopInformation(Request $request)
    {
        $shops = Shop::with('area', 'genre')->get();

        $areas = Area::all();
        $genres = Genre::all();

        return view('admin.shop.create', compact('shops','areas', 'genres'));
    }

    public function createShop(Request $request)
    {
        $user = auth()->user();
        $areas = Area::all();
        $genres = Genre::all();

        if ($user->shop_id) {
            return redirect()->route('shop.create')->with('error', 'あなたは既に店舗を持っています。');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'genre_id' => 'required|exists:genres,id',
            'description' => 'required|string',
            'image_path' => 'nullable|string',
        ]);

        $shopInfo = Shop::create([
            'name' => $request->name,
            'area_id' => $request->area_id,
            'genre_id' => $request->genre_id,
            'description' => $request->description,
            'image_path' => $request->image_path,
        ]);

        $user->shop_id = $shopInfo->id;
        $user->save();

        return view('admin.shop.create', compact('areas', 'genres','shopInfo'))->with('success', '店舗情報を作成しました。');
    }

    public function editShop()
    {
        $shopId = Auth::user()->shop_id;
        $shop = Shop::findOrFail($shopId);

        $areas = Area::all();
        $genres = Genre::all();

        return view('manager.edit', compact('shop','areas', 'genres'));
    }

    public function updateShop(Request $request)
    {
        $shopId = Auth::user()->shop_id;
        $shop = Shop::findOrFail($shopId);

        $request->validate([
            'name' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'genre_id' => 'required|exists:genres,id',
            'description' => 'required|string',
            'image_path' => 'nullable|string',
        ]);

        $shop->update([
            'name' => $request->name,
            'area_id' => $request->area_id,
            'genre_id' => $request->genre_id,
            'description' => $request->description,
            'image_path' => $request->image_path,
        ]);

        return redirect()->back()->with('success', '店舗情報を更新しました。');
    }

    public function reservationsIndex(Request $request)
    {
        $shopId = Auth::user()->shop_id;

        $date = $request->input('date', Carbon::today()->toDateString());

        $reservations = Reservation::where('shop_id', $shopId)
                                    ->whereDate('date', $date)
                                    ->orderBy('date')
                                    ->orderBy('time')
                                    ->get();

        $previousDate = Carbon::parse($date)->subDay()->toDateString();
        $nextDate = Carbon::parse($date)->addDay()->toDateString();

        return view('manager.index', compact('reservations', 'date', 'previousDate', 'nextDate'));
    }

    public function adminNotifyMail(Request $request)
    {
        return view("admin/notify");
    }

    public function managerNotifyMail(Request $request)
    {
        return view("manager/notify");
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new UserNotification($request->subject, $request->message));
        }

        return redirect()->route('admin.notify')->with('success', 'メールの送信に成功しました。');
    }

    public function qrConfirm(Request $request)
    {
        $reservation_id = $request->input('reservation_id');
        $reservation = Reservation::find($reservation_id);

        if ($reservation) {
            $reservation->status = 2; // 来店済
            $reservation->save();
            return response()->json(['message' => '来店が確認されました。']);
        }

        return response()->json(['message' => '予約が見つかりませんでした。'], 404);
    }
}