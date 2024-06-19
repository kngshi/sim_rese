<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;


class FavoriteController extends Controller
{
    public function addFavorite(Request $request)
    {
        $user_id = Auth::id();
        $shop_id = $request->input('shop_id');

        $favoriteData = [
            'user_id' => $user_id,
            'shop_id' => $shop_id,
        ];

        $favorite = Favorite::create($favoriteData);

        if ($favorite) {
            return redirect('/')->with('create', 'お気に入りに追加しました');
        } else {
            return redirect()->back()->with('fail', 'お気に入り追加に失敗しました。');
        }
    }

    public function deleteFavorite(Request $request)
    {
        $user_id = Auth::id();
        $shop_id = $request->input('shop_id');

        $deleted = Favorite::where('user_id', $user_id)
                            ->where('shop_id', $shop_id)
                            ->delete();

        if ($deleted) {
            return redirect('/')->with('delete', 'お気に入りを削除しました');
        } else {
            return redirect()->back()->with('fail', 'お気に入りの削除に失敗しました。');
        }
    }

    public function delete(Request $request)
    {
        $user_id = $request->user()->id;
        $shop_id = $request->input('shop_id');

        $deleted = Favorite::where('user_id', $user_id)
                            ->where('shop_id', $shop_id)
                            ->delete();

        if ($deleted) {
            return redirect('/mypage')->with('success', 'お気に入りを解除しました');
        } else {
            return redirect('/mypage')->with('error', 'お気に入りの解除に失敗しました');
        }
    }
}