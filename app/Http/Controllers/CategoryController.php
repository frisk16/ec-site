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
    public function show(Request $request, Category $category)
    {
        $major_categories = MajorCategory::all();
        $count = $category->products()->where('public_flag', true)->count();
        $products = $category->products()->where('public_flag', true)->latest()->paginate(12);
        $storage = Storage::disk('s3');
        
        // 価格順
        if($request->has('sort_price')) {
            if($request->sort_price === 'asc') {
                $products = $category->products()->where('public_flag', true)->orderBy('price', 'ASC')->paginate(12);
            } else {
                $products = $category->products()->where('public_flag', true)->orderBy('price', 'DESC')->paginate(12);
            }
        }
        // 更新順
        if($request->has('sort_update')) {
            if($request->sort_update === 'asc') {
                $products = $category->products()->where('public_flag', true)->orderBy('updated_at', 'ASC')->paginate(12);
            } else {
                $products = $category->products()->where('public_flag', true)->orderBy('updated_at', 'DESC')->paginate(12);
            }
        }
        

        return view('categories.show', compact('category', 'major_categories', 'products', 'storage', 'count'));
    }
}
