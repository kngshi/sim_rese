<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $shops = Shop::with('area', 'genre')->get();
        $areas = Area::all();
        $genres = Genre::all();

        return view('index', compact('shops', 'areas', 'genres'));
    }

    public function sort(Request $request)
    {
        $sort = $request->input('sort');

        $shops = Shop::query()
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        if ($sort === 'random') {
            $shops = $shops->inRandomOrder();
        } elseif ($sort === 'high_rating') {
            $shops = $shops->orderByRaw('reviews_avg_rating IS NULL ASC')
                ->orderBy('reviews_avg_rating', 'desc')
                ->orderBy('id', 'asc');
        } elseif ($sort === 'low_rating') {
            $shops = $shops->orderByRaw('reviews_avg_rating IS NULL ASC')
                ->orderBy('reviews_avg_rating', 'asc')
                ->orderBy('id', 'asc');
        }

        $shops = $shops->get();
        $areas = Area::all();
        $genres = Genre::all();

        return view('index', compact('shops', 'areas', 'genres'));
    }

    public function detail($shop_id)
    {
        $shop = Shop::findOrFail($shop_id);
        $reviews = Review::where('shop_id', $shop_id)->get();

        $existingReview = Review::where('user_id', auth()->id())
            ->where('shop_id', $shop_id)
            ->first();

        return view('detail', compact('shop', 'reviews', 'existingReview'));
    }

    public function search(Request $request)
    {
        if ($request->has('reset')) {
            return redirect('/')->withInput();
        }

        $shops = Shop::with('area', 'genre')
            ->when($request->filled('area_id'), function ($query) use ($request) {
                $query->where('area_id', $request->area_id);
            })
            ->when($request->filled('genre_id'), function ($query) use ($request) {
                $query->where('genre_id', $request->genre_id);
            })
            ->KeywordSearch($request->keyword)
            ->get();

        $areas = Area::all();
        $genres = Genre::all();

        return view('index', compact('shops', 'areas', 'genres'));
    }

    public function mypageIndex()
    {
        $user_id = Auth::id();
        $favorites = Favorite::where('user_id', $user_id)->with('shop')->get();

        $reservations = Reservation::where('user_id', $user_id)->with('shop')->orderBy('date', 'asc')->get()->map(function ($reservation) {
            $reservation->time = Carbon::createFromFormat('H:i:s', $reservation->time)->format('H:i');
            return $reservation;

            $reservation->qrCode = QrCode::size(100)->generate($reservation->id);

            return $reservation;
        });

        return view('mypage', compact('favorites', 'reservations'));
    }
}
