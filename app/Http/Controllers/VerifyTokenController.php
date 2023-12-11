<?php

namespace App\Http\Controllers;

use App\Models\VerifyToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyTokenController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->type !== 'subscription' && $request->type !== 'cancel_subscription') {
            return to_route('verify.token_error');
        }

        return view('verify.index');
    }

    public function token_error()
    {
        return view('verify.token_error');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function verify_token(Request $request)
    {
        $user = Auth::user();
        if(!password_verify($request->input('password'), $user->password)) {
            return back()->with('error_password', 'パスワードが違います');
        }

        $token = bin2hex(random_bytes(32));

        $my_token = VerifyToken::where('user_id', $user->id)->first();
        if($my_token) {
            $my_token->token = $token;
            $my_token->update();
        } else {
            $my_token = new VerifyToken();
            $my_token->user_id = $user->id;
            $my_token->token = $token;
            $my_token->save();
        }

        if($request->input('type') === 'subscription') {
            return redirect()->to('mypage/subscription?token='.$token);
        } elseif($request->input('type') === 'cancel_subscription') {
            return redirect()->to('mypage/cancel_subscription?token='.$token);
        } else {
            return to_route('verify.token_error');
        }
    }
}
