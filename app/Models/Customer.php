<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }


    // Attributes
    public function getBrandIconAttribute()
    {
        $icons = [
            'Visa' => 'text-primary fa-brands fa-cc-visa',
            'MasterCard' => 'text-tertiary fa-brands fa-cc-mastercard',
            'JCB' => 'text-success fa-brands fa-cc-jcb',
            'American Express' => 'text-quinary fa-brands fa-cc-amex',
            'Diners Club' => 'text-primary fa-brands fa-cc-diners-club',
            'Discover' => 'text-tertiary fa-brands fa-cc-discover',
        ];

        if(empty($icons[$this->brand])) {
            return 'fa-solid fa-credit-card';
        } else {
            return $icons[$this->brand];
        }
    }

    public function getCustomExpAttribute()
    {
        $exp_date = explode('/', $this->exp);

        return $exp_date[1].'年'.' / '.$exp_date[0].'月';
    }
}
