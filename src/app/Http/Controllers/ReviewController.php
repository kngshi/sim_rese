<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($shopId)
    {
        $shop = Shop::findOrFail($shopId);
        $reviews = Review::where('shop_id', $shopId)->latest()->get();

        return view('create', compact('shop', 'reviews'));
    }

    public function store(ReviewRequest $request)
    {
        $existingReview = Review::where('user_id', auth()->id())
            ->where('shop_id', $request->shop_id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->withErrors(['review' => 'この店舗にはすでに口コミを投稿済みです。']);
        }

        if ($request->hasFile('img_url')) {
            $imagePath = $request->file('img_url')->store('uploads', 'public');
        } else {
            $imagePath = null;
        }

        $review = Review::create([
            'shop_id' => $request->input('shop_id'),
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'img_url' => $imagePath,
        ]);

        return redirect()->route('detail', $review->shop_id)->with('success', 'レビューを投稿しました。');
    }

    public function edit(Review $review)
    {
        $shop = $review->shop;

        return view('create', compact('review', 'shop'));
    }

    public function update(ReviewRequest $request, Review $review)
    {
        $validated = $request->validated();

        if ($request->hasFile('img_url')) {
            // 古い画像がある場合は削除する処理をここに追加（オプション）
            // 新しい画像を保存
            $imagePath = $request->file('img_url')->store('public/reviews');
            $validated['img_url'] = basename($imagePath);
        }

        $review->update($validated);

        return redirect()->route('detail', $review->shop_id)->with('success', '口コミが更新されました。');
    }
}
