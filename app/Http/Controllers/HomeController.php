<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\MajorCategory;
use App\Models\Product;

class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $storage = Storage::disk('s3');
        $major_categories = MajorCategory::all();
        $products = Product::where('public_flag', true);
        $new_top10_products = $products->latest()->limit(6)->get();
        $recommend_products = $products->where('recommend_flag', true)->get();

        return view('home', compact('storage', 'major_categories', 'new_top10_products', 'recommend_products'));
    }

    public function reset_complete()
    {
        return view('auth.passwords.complete');
    }
}
