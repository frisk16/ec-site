<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'des_name',
        'des_postal_code',
        'des_address',
        'des_phone_number',
        'carriage',
        'total_qty',
        'total_price',
        'cancel_flag',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ordered_products()
    {
        return $this->hasMany(OrderedProduct::class);
    }

    public function getAllCompletedAttribute()
    {
        $completed_flag = false;
        $items = $this->ordered_products();
        if($items->where('completed_flag', false)->doesntExist()) {
            $completed_flag = true;
        }

        return $completed_flag;
    }
}
