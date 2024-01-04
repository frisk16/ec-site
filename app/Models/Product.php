<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function getReviewScoreAttribute()
    {
        $total_score = 0;
        foreach($this->reviews()->get() as $review) {
            $total_score += $review->score;
        }

        if($this->reviews()->exists()) {
            $current_score = round($total_score / $this->reviews()->count(), 1);
        } else {
            $current_score = 0;
        }

        return $current_score;
    }

    public function getReviewCountAttribute()
    {
        if($this->reviews()->exists()) {
            $count = $this->reviews()->count();
        } else {
            $count = 0;
        }

        return $count;
    }
}
