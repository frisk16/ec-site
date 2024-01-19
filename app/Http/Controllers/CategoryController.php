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
        $count = $category->products()->where('public_flag', true)->count();
        $products = $category->products()->where('public_flag', true)->latest()->paginate(12);
        $storage = Storage::disk('s3');

        return view('categories.show', compact('category', 'major_categories', 'products', 'storage', 'count'));
    }
}
