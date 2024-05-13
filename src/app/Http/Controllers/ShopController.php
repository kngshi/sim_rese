<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {

    $shops = Shop::with('area', 'genre')->get();
    $areas = Area::all();
    $genres = Genre::all();

    return view('index', compact('shops', 'areas', 'genres' ));
    }


    public function detail(Shop $shop)
    {
    return view('detail', compact('shop'));
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


    public function mypage(Request $request)
    {

    $shops = Shop::with('area', 'genre')->get();

    $reservations = Auth::user()->reservations()->with('shop')->get();

    return view('mypage', compact('shops', 'reservations' ));
    }

}
