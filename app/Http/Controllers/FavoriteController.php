<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $count = Auth::user()->favorites()->count();
        $favorites = Auth::user()->favorites()->paginate(10);
        $storage = Storage::disk('s3');

        return view('mypage.favorite', compact('favorites', 'storage', 'count'));
    }

    // 登録、削除
    public function toggle_favorite(Request $request)
    {
        $product_id = $request->input('product_id');
        $current_favorite = Favorite::where('user_id', Auth::id())->where('product_id', $product_id);

        if($current_favorite->exists()) {
            $current_favorite->first()->delete();

            return back();
        } else {
            $new_favorite = new Favorite();
            $new_favorite->user_id = Auth::id();
            $new_favorite->product_id = $product_id;
            $new_favorite->save();

            return back();
        }
    }
}
