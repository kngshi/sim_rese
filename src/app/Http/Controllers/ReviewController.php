<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Review;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($shopId)
    {
        $shop = Shop::findOrFail($shopId);
        $reviews = Review::latest()->get();

        return view('create', compact('shop', 'reviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::create([
            'shop_id' => $request->input('shop_id'),
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'レビューを投稿しました。');
    }
}
