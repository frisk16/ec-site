<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MajorCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $major_categories = MajorCategory::all();
        $products = $category->products()->where('public_flag', true)->latest()->get();
        $storage = Storage::disk('s3');

        return view('categories.show', compact('category', 'major_categories', 'products', 'storage'));
    }
}
