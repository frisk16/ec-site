<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;

class CustomerController extends Controller
{
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

        return view('mypage.credit_card', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $my_cards = $user->customers();

        if($my_cards->get()->count() < 2) {
            $token = $request->input('stripeToken');
            $input_data = $this->stripe->tokens->retrieve($token)->card;
            $input_name = $user->last_name . ' ' . $user->first_name;

            if($my_cards->where('brand', $input_data->brand)->where('last4_number', $input_data->last4)->first()) {
                return back()->with('error_msg', 'そのカードは既に登録されています');
            }

            $customer_data = $this->stripe->customers->create([
                'source' => $token,
                'name' => $input_name,
                'email' => $user->email,
            ]);

            $customer = new Customer();
            $customer->user_id = $user->id;
            $customer->cus_code = $customer_data->id;
            $customer->name = $input_name;
            $customer->email = $user->email;
            $customer->last4_number = $input_data->last4;
            $customer->brand = $input_data->brand;
            $customer->exp = $input_data->exp_month . '/' . $input_data->exp_year;
            if(!$my_cards->where('enabled', true)->doesntExist()) {
                $customer->enabled = true;
            }
            $customer->save();

            return back()->with('success_msg', 'カードが追加されました');

        } else {

            return back()->with('error_msg', '登録できる枚数は2枚までです');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update_enabled(Customer $customer)
    {
        $enabled_customer = Auth::user()->customers()->where('enabled', true)->first();
        $enabled_customer->enabled = false;
        $enabled_customer->update();

        if(!$enabled_customer->enabled) {
            $customer->enabled = true;
            $customer->update();
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if($customer->enabled) {
            $disabled_customer = Auth::user()->customers()->where('enabled', false)->first();
            $disabled_customer->enabled = true;
            $disabled_customer->update();
        }

        $delete_customer = $this->stripe->customers->delete($customer->cus_code);

        if($delete_customer->deleted) {
            $customer->delete();
        }

        return back()->with('success_msg', 'カードを削除しました');
    }
}
