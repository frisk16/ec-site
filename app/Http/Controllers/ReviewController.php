<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewRequest $request)
    {
        $user = Auth::user();

        $review = new Review();
        $review->user_id = $user->id;
        $review->product_id = $request->input('product_id');
        $review->name = $request->input('name');
        $review->score = $request->input('score');
        $review->comment = $request->input('comment');
        $review->save();

        return back()->with('success_msg', 'レビューを投稿しました');
    }
}
