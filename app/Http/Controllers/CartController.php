<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $storage = Storage::disk('s3');
        $carts = Auth::user()->carts()->latest()->get();
        $sub_total_price = 0;
        $carriage = false;
        foreach($carts as $cart) {
            $sub_total_price += $cart->product->price * $cart->qty;
            if($cart->product->carriage_flag) {
                $carriage = true;
            }
        }

        return view('mypage.cart', compact('storage', 'carts', 'sub_total_price', 'carriage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = Auth::id();
        $product_id = $request->input('product_id');
        $qty = $request->input('qty');
        if($qty === null) {
            $qty = 1;
        }

        $added_product = Cart::where('user_id', $user_id)->where('product_id', $product_id);

        if($added_product->exists()) {
            $cart = $added_product->first();
            $cart->qty += $qty;
            $cart->update();
        } else {
            $cart = new Cart();
            $cart->user_id = $user_id;
            $cart->product_id = $product_id;
            $cart->qty = $qty;
            $cart->save();
        }
        
        return back()->with('cart_msg', 'カートに追加しました');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        $qty = $request->input('qty');
        $cart->qty = $qty;
        $cart->update();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return back();
    }
}
