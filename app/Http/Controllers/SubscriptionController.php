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
    private $stripe;
    private $paid_price_code;

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
        // トークン認証
        if($request->has('token')) {
            $my_token = VerifyToken::where('user_id', Auth::id());
            if($my_token->exists()) {
                if($my_token->first()->token !== $request->token) {
                    return to_route('verify.token_error');
                }
            } else {
                return to_route('verify.token_error');
            }
        } else {
            return to_route('verify.token_error');
        }
        // 

        $customers = Auth::user()->customers()->get();

        return view('mypage.subscription', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $use_sub = Subscription::where('user_id', Auth::id())->where('period_end_at', null);
        if($use_sub->doesntExist()) {
            $customer_id = $request->input('customer_id');
            $cus_code = Customer::find($customer_id)->cus_code;
            $subscription_data = null;

            $subscription_data = $this->stripe->subscriptions->create([
                'customer' => $cus_code,
                'items' => [
                    ['price' => $this->paid_price_code],
                ],
            ]);

            $amount = $this->stripe->prices->retrieve($this->paid_price_code)->unit_amount;
            if(isset($subscription_data)) {
                $user = User::find(Auth::id());
                $user->role_id = 2;
                $user->update();

                if($user->role_id === 2) {
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

    public function cancel_subscription(Request $request)
    {
        if($request->has('token')) {
            $my_token = VerifyToken::where('user_id', Auth::id());
            if($my_token->exists()) {
                if($my_token->first()->token !== $request->token) {
                    return to_route('verify.token_error');
                }
            } else {
                return to_route('verify.token_error');
            }
        } else {
            return to_route('verify.token_error');
        }

        return view('mypage.cancel_subscription');
    }

    public function complete()
    {
        $user = User::find(Auth::id());

        if($user->subscriptions()->doesntExist()) {
            return to_route('verify.token_error');
        }

        $my_token = VerifyToken::where('user_id', Auth::id())->first();
        if($my_token) {
            $my_token->delete();
        }

        $sub_code = $user->subscriptions->first()->sub_code;
        $current_period_end = $this->stripe->subscriptions->retrieve($sub_code)->current_period_end;
        $next_payment_day = Carbon::parse($current_period_end)->format('Y年m月d日');

        return view('mypage.subscription_complete', compact('next_payment_day'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function disabled_subscription()
    {
        $use_sub = Subscription::where('user_id', Auth::id())->where('period_end_at', null);
        if($use_sub->exists()) {
            $sub_code = $use_sub->first()->sub_code;
            $current_period_end = $this->stripe->subscriptions->retrieve($sub_code)->current_period_end;
            $format_end_date = Carbon::parse($current_period_end)->toDateString();
            $cancel_sub = null;

            $cancel_sub = $this->stripe->subscriptions->cancel($sub_code, []);

            if(isset($cancel_sub)) {
                $old_subscription = $use_sub->first();
                $old_subscription->period_end_at = $format_end_date;
                $old_subscription->update();

                $user = User::find(Auth::id());
                $user->cancel_flag = true;
                $user->update();
            } else {
                return back()->with('error_msg', '解約処理中にエラーが発生しました');
            }
            
            return to_route('subscriptions.complete_cancel');

        } else {
            return to_route('customers.index')->with('error_msg', '既に有料会員を解約済みです');
        }
        
    }

    public function complete_cancel()
    {
        $period_end_at = Subscription::where('user_id', Auth::id())->orderBy('period_end_at', 'DESC')->first()->period_end_at;
        $format_end_date = Carbon::parse($period_end_at)->format('Y年m月d日');

        if(!isset($period_end_at)) {
            return to_route('verify.token_error');
        }

        return view('mypage.complete_cancel_sub', compact('format_end_date'));
    }
}
