<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Topic;
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
        $topics = Topic::where('public_flag', true)->latest()->limit(3)->get();
        $major_categories = MajorCategory::all();

        $products = Product::where('public_flag', true);
        $new_products = $products->latest()->limit(4)->get();
        $recommend_products = $products->where('recommend_flag', true)->orderBy('updated_at', 'DESC')->limit(8)->get();

        $pop_products = [];
        $cnt = 0;
        foreach(Product::where('public_flag', true)->latest()->get() as $product) {
            if($product->review_score >= 4 && $product->review_count >= 5) {
                if($cnt < 4) {
                    $pop_products[] = $product;
                }
                $cnt++;
            }
        }
        
        return view('home', compact('storage', 'topics', 'major_categories', 'new_products', 'pop_products', 'recommend_products'));
    }

    public function reset_complete()
    {
        return view('auth.passwords.complete');
    }
}
