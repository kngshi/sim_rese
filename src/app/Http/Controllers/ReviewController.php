<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($shopId)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 2) {
            return back()->with('error', '店舗責任者は口コミを投稿できません。');
        }

        $shop = Shop::findOrFail($shopId);
        $reviews = Review::where('shop_id', $shopId)->latest()->get();

        return view('review', compact('shop', 'reviews'));
    }

    public function store(ReviewRequest $request)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 2) {
            return back()->with('error', '店舗責任者は口コミを投稿できません。');
        }

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
        if (auth()->user()->role == 1 || auth()->user()->role == 2) {
            return back()->with('error', '店舗責任者は口コミを編集できません。');
        }

        $shop = $review->shop;

        return view('review', compact('review', 'shop'));
    }

    public function update(ReviewRequest $request, Review $review)
    {
        if (auth()->user()->role == 1 || auth()->user()->role == 2) {
            return back()->with('error', '店舗責任者は口コミを更新できません。');
        }

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

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $user = auth()->user();

        if ($user->role == 2) {
            return back()->with('error', '店舗責任者は口コミを削除できません。');
        }

        if ($user->role == 1) {
            $review->delete();
            return redirect()->route('detail', ['shop' => $review->shop_id])
                ->with('message', '口コミを削除しました（管理者）。');
        }

        if ($user->role == 3 && $review->user_id === $user->id) {
            $review->delete();
            return redirect()->route('detail', ['shop' => $review->shop_id])
                ->with('message', '口コミを削除しました。');
        }

        return redirect()->route('detail', ['shop' => $review->shop_id])
            ->with('error', '削除する権限がありません。');
    }

    public function index($shopId)
    {
        $shop = Shop::find($shopId);
        $reviews = Review::where('shop_id', $shopId)
            ->with('user')
            ->get();

        return view('reviews.review-index', compact('shop', 'reviews'));
    }
}
