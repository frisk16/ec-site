<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Stripe\StripeClient;
use Carbon\Carbon;

class UserController extends Controller
{
    private $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.secret_key'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $sub_data = null;
        $next_payment_at = null;
        $sub_retrieve = null;
        $use_card = null;

        if($user->role->id === 2) {
            if($user->cancel_flag) {
                $end_date = $user->subscriptions()->orderBy('period_end_at', 'DESC')->first()->period_end_at;
                $next_payment_at = Carbon::parse($end_date)->format('Y年m月d日');
                $use_card = $user->customers()->where('enabled', true)->first();
            } else {
                $sub_code = $user->subscriptions()->where('period_end_at', null)->first()->sub_code;
                $sub_retrieve = $this->stripe->subscriptions->retrieve($sub_code);
                $next_payment_at = Carbon::parse($sub_retrieve->current_period_end)->format('Y年m月d日');
                $use_card = $user->customers()->where('enabled', true)->first();
            }
        } else {
            if($user->customers()->exists()) {
                $use_card = $user->customers()->where('enabled', true)->first();
            }
        }

        return view('mypage.index', compact('user', 'sub_retrieve', 'next_payment_at', 'use_card'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit_info()
    {
        $user = Auth::user();
        $areas = $this->areas();

        return view('mypage.edit_info', compact('user', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_info(UserRequest $request)
    {
        $id = Auth::id();
        $user = User::find($id);

        $user->email = $request->input('email');
        $user->last_name = $request->input('last_name');
        $user->first_name = $request->input('first_name');
        $user->age = $request->input('age');
        $user->postal_code = $request->input('postal_code');
        $user->area = $request->input('area');
        $user->address = $request->input('address');
        $user->phone_number = $request->input('phone_number');
        $user->update();

        return to_route('mypage.index')->with('success_msg', '会員情報が更新されました');
    }

    public function edit_password()
    {
        return view('mypage.edit_password');
    }

    public function update_password(Request $request)
    {
        $id = Auth::id();
        $user = User::find($id);

        if(!password_verify($request->input('current_password'), $user->password)) {
            return back()->with('error_password', '現在のパスワードが一致しません');
        }

        $request->validate([
            'password' => 'min:8 | confirmed',
        ], [
            'password.min' => ':min文字以上必須',
            'password.confirmed' => '確認用パスワードと一致しません',
        ]);

        $user->password = bcrypt($request->input('password'));
        $user->update();

        return to_route('mypage.index')->with('success_msg', 'パスワードが更新されました');
    }

    // 都道府県
    public function areas()
    {
        return ['北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県','新潟県','富山県','石川県','福井県','山梨県','長野県','岐阜県','静岡県','愛知県','三重県','滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県','鳥取県','島根県','岡山県','広島県','山口県','徳島県','香川県','愛媛県','高知県','福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県'];
    }
}
