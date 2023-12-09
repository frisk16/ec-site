<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subscription;
use App\Models\Customer;
use App\Models\VerifyToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.secret_key'));
        $this->paid_price_code = config('stripe.paid_price_id');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // トークン認証 ----------
        $my_token = VerifyToken::where('user_id', Auth::id())->first();
        if($request->has('token')) {
            if($my_token->token !== $request->token) {
                return redirect()->to('verify?type=subscription');
            }
        } else {
            return redirect()->to('verify?type=subscription');
        }
        // ----------

        $customers = Auth::user()->customers()->get();

        return view('mypage.subscription', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        if(Auth::user()->subscriptions()->doesntExist()) {
            $customer_id = $request->input('customer_id');
            $cus_code = Customer::find($customer_id)->cus_code;

            $subscription_data = $this->stripe->subscriptions->create([
                'customer' => $cus_code,
                'items' => [
                    ['price' => $this->paid_price_code],
                ],
            ]);

            $amount = $this->stripe->prices->retrieve($this->paid_price_code)->unit_amount;
            if(!empty($subscription_data)) {
                $user = User::find(Auth::id());
                $user->role_id = 2;
                $user->update();

                if($user->role_id == 2) {
                    $subscription = new Subscription();
                    $subscription->customer_id = $customer_id;
                    $subscription->user_id = Auth::id();
                    $subscription->sub_code = $subscription_data->id;
                    $subscription->amount = $amount;
                    $subscription->save();
                }
            } else {
                return back()->with('error_msg', '登録中にエラーが発生しました');
            }

            return to_route('subscriptions.complete');
        } else {
            return back()->with('error_msg', '既に登録済みです');
        }
    }

    public function complete()
    {
        $user = Auth::user();

        if($user->subscriptions()->doesntExist()) {
            return to_route('verify.token_error');
        }

        $my_token = VerifyToken::where('user_id', $user->id)->first();
        if($my_token) {
            $my_token->delete();
        }

        $sub_code = $user->subscriptions()->first()->sub_code;
        $current_period_end = $this->stripe->subscriptions->retrieve($sub_code)->current_period_end;
        $next_payment_day = Carbon::parse($current_period_end)->format('Y年m月d日');

        return view('mypage.subscription_complete', compact('next_payment_day'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
