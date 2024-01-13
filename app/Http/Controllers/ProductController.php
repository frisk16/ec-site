<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $storage = Storage::disk('s3');
        $reviews = $product->reviews();
        
        return view('products.show', compact('storage', 'product', 'reviews'));
    }

    public function store_review(Product $product, ReviewRequest $request)
    {
        $user = Auth::user();

        $review = new Review();
        $review->user_id = $user->id;
        $review->product_id = $product->id;

        if($request->input('name') !== null) {
            $review->name = $request->input('name');
        
        } else {
            $review->name = '名無しさん';
        
        }
        $review->score = $request->input('score');
        $review->comment = $request->input('comment');
        $review->save();

        return back()->with('success_msg', 'レビューを投稿しました');
    }

    public function show_review(Product $product)
    {
        $storage = Storage::disk('s3');
        $reviews = $product->reviews()->latest()->get();

        if($product->reviews()->doesntExist()) {
            return back();
        }

        return view('products.review', compact('product', 'reviews', 'storage'));
    }

    public function search(Request $request)
    {
        $category_name = null;
        $max_price = null;
        $keyword = null;
        $storage = Storage::disk('s3');

        if($request->has('keyword')) {
            $keyword = $request->keyword;

            if($request->has('category_id') && $request->has('max_price')) {
                $category_id = $request->category_id;
                $max_price = $request->max_price;
                if($category_id !== null) {
                    $category_name = Category::find($category_id)->name;
                    $products = Product::where('category_id', $category_id)->where('price', '<=', $max_price)->where('name', 'LIKE', '%'.$keyword.'%')->latest()->get();

                } else {
                    $products = Product::where('price', '<=', $max_price)->where('name', 'LIKE', '%'.$keyword.'%')->latest()->get();
                }

            } else {
                $products = Product::where('name', 'LIKE', '%'.$keyword.'%')->latest()->get();
           
            }
        } else {
            return back();
        }

        return view('products.search', compact('products', 'max_price', 'category_name', 'storage'));
    }
}
