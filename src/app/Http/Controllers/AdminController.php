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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


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
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users|max:191',
            'role' => 'required',
            'password' => 'required|string|min:8|max:191',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => '2',
            'password' => Hash::make($request->password),
        ]);

        return view('admin.create', compact('user', 'shopManagers'))->with('success', '店舗代表者を作成しました。');
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

        return view('manager.create', compact('shops', 'areas', 'genres'));
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
            'name' => 'required|string|max:50',
            'area_id' => 'required|exists:areas,id',
            'genre_id' => 'required|exists:genres,id',
            'description' => 'required|string|max:400',
            'image_path' => 'required|image|mimes:jpeg,png|max:2048',
        ]);

        $imageFile = $request->file('image');

        $fileName = $imageFile->getClientOriginalName();

        $localPath = $imageFile->storeAs('images', $fileName, 'public');
        $localUrl = Storage::url($localPath);


        $shopInfo = Shop::create([
            'name' => $request->name,
            'area_id' => $request->area_id,
            'genre_id' => $request->genre_id,
            'description' => $request->description,
            'image_path' => $localUrl,
        ]);

        $user->shop_id = $shopInfo->id;

        return view('manager.create', compact('areas', 'genres', 'shopInfo'))->with('success', '店舗情報を作成しました。');
    }

    public function editShop()
    {
        $shopId = Auth::user()->shop_id;
        $shop = Shop::find($shopId);

        if (!$shop) {
            return view('manager.edit', ['shop' => null, 'message' => 'あなたはまだ店舗を持っていません。']);
        }

        $areas = Area::all();
        $genres = Genre::all();

        return view('manager.edit', compact('shop', 'areas', 'genres'));
    }

    public function updateShop(Request $request)
    {
        $shopId = Auth::user()->shop_id;
        $shop = Shop::findOrFail($shopId);

        $request->validate([
            'name' => 'required|string|max:50',
            'area_id' => 'required|exists:areas,id',
            'genre_id' => 'required|exists:genres,id',
            'description' => 'required|string|max:400',
            'image_path' => 'required|image|mimes:jpeg,png|max:2048',
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

    public function showCsvImportForm()
    {
        return view('admin.csv-import');
    }

    public function importCsv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $filePath = $request->file('csv_file')->store('csv');

        $file = fopen(storage_path("app/{$filePath}"), 'r');
        $header = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            $data = array_combine($header, $row);

            if (empty($data['店舗名']) || empty($data['地域']) || empty($data['ジャンル']) || empty($data['店舗概要']) || empty($data['画像URL'])) {
                return redirect()->back()->withErrors('必須入力項目が不足しています。')->withInput();
            }

            if (strlen($data['店舗名']) > 50) {
                return redirect()->back()->withErrors('店舗名は50文字以内で入力してください。')->withInput();
            }

            $validAreas = ['東京都', '大阪府', '福岡県'];
            if (!in_array($data['地域'], $validAreas)) {
                return redirect()->back()->withErrors('地域は「東京都」「大阪府」「福岡県」のいずれかで入力してください。')->withInput();
            }

            $validGenres = ['寿司', '焼肉', 'イタリアン', '居酒屋', 'ラーメン'];
            if (!in_array($data['ジャンル'], $validGenres)) {
                return redirect()->back()->withErrors('ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかで入力してください。')->withInput();
            }

            if (strlen($data['店舗概要']) > 400) {
                return redirect()->back()->withErrors('店舗概要は400文字以内で入力してください。')->withInput();
            }

            if (!preg_match('/\.(jpeg|jpg|png)$/i', $data['画像URL'])) {
                return redirect()->back()->withErrors('画像URLはjpegまたはpng形式の画像を指定してください。')->withInput();
            }

            $area = Area::where('name', $data['地域'])->first();
            $genre = Genre::where('name', $data['ジャンル'])->first();

            if (!$area || !$genre) {
                continue;
            }

            $shop = new Shop();
            $shop->name = $data['店舗名'];
            $shop->area_id = $area->id;
            $shop->genre_id = $genre->id;
            $shop->description = $data['店舗概要'];
            $shop->image_path = $data['画像URL'];

            $shop->save();
        }

        fclose($file);

        return redirect()->back()->with('success', 'CSVファイルが正常にインポートされました。');
    }
}
