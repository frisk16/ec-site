<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
}
