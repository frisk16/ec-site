<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\VerifyToken;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Stripe\StripeClient;


class OrderController extends Controller
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
        $orders = Auth::user()->orders()->latest()->get();

        return view('orders.index', compact('orders'));
    }

    public function confirm(Request $request)
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

        $user = Auth::user();
        $carts = $user->carts()->latest()->get();
        $storage = Storage::disk('s3');
        $credit = $user->customers()->where('enabled', true)->first();
        $total_price = 0;
        $total_qty = 0;
        $carriage = false;
        foreach($carts as $cart) {
            $total_price += $cart->product->price * $cart->qty;
            $total_qty += $cart->qty;
            if($cart->product->carriage_flag) {
                $carriage = true;
            }
        }
        if($carriage) {
            $total_price += 300;
        }

        return view('orders.confirm', compact('user', 'carts', 'storage', 'credit', 'total_price', 'total_qty', 'carriage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $cus_code = Auth::user()->customers()->where('enabled', true)->first()->cus_code;
        $charge = $this->stripe->charges->create([
            'amount' => $request->input('total_price'),
            'currency' => 'jpy',
            'customer' => $cus_code,
        ]);
        
        if($charge) {
            $order_code = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 20);
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => $order_code,
                'des_name' => $request->input('des_name'),
                'des_postal_code' => $request->input('des_postal_code'),
                'des_address' => $request->input('des_address'),
                'des_phone_number' => $request->input('des_phone_number'),
                'carriage' => $request->input('carriage'),
                'total_qty' => $request->input('total_qty'),
                'total_price' => $request->input('total_price'),
            ]);

            if($order) {
                $carts = Auth::user()->carts()->get();
                foreach($carts as $cart) {
                    $ordered_product = new OrderedProduct();
                    $ordered_product->order_id = $order->id;
                    $ordered_product->product_id = $cart->product_id;
                    $ordered_product->total_qty = $cart->qty;
                    $ordered_product->total_price = $cart->product->price * $cart->qty;
                    $ordered_product->save();
                    $cart->delete();
                }
            } else {
                return back()->with('error_msg', 'エラーが発生しました、管理人にお問い合わせください');
            }

        } else {
            return back()->with('error_msg', 'エラーが発生しました、管理人にお問い合わせください');
        }
        
        return to_route('orders.complete', ['token' => $request->input('token'), 'order_code' => $order_code]);
    }

    public function complete(Request $request)
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

        if($request->has('order_code')) {
            $my_orders = Auth::user()->orders();
            if($my_orders->where('order_code', $request->order_code)->doesntExist()) {
                return to_route('verify.token_error');
            }
        } else {
            return to_route('verify.token_error');
        }

        $order_code = $request->order_code;
        $order = Order::where('order_code', $order_code)->first();
        
        return view('orders.complete', compact('order_code', 'order'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if(Auth::user()->orders()->where('id', $order->id)->doesntExist()) {
            return back();
        }

        $storage = Storage::disk('s3');
        $items = $order->ordered_products()->latest()->get();

        return view('orders.show', compact('storage', 'order', 'items'));
    }

    public function cancel_order(OrderedProduct $item)
    {
        if(!$item->cancel_flag) {
            $item->cancel_flag = true;
            $item->update();
        } else {
            return back();
        }

        return back()->with('success_msg', 'キャンセルを受け付けました');
    }
}
