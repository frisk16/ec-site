@extends('layouts.app')

@section('title')
    マイページ｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-11">

                <h5 class="title">マイページ</h5>

                <div class="row justify-content-center">
                    <div class="col-12 card p-0 mb-3 shadow">
                        <div class="card-header bg-quinary text-white fw-bold">
                            <div class="d-flex justify-content-between align-items-center my-auto">
                                @if($user->role->id === 2)
                                    <p>有料会員</p>
                                    <p>次回の支払い｜{{ $next_payment_at }}</p>
                                @else
                                    <p>無料会員</p>
                                    <p>次回の支払い｜無し</p>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row justify-content-center align-items-center">
                                    
                                @if($user->customers()->exists())
                                    <div class="col-3 border-end text-center">
                                        <i class="fa-4x {{ $use_card->brand_icon }}"></i>
                                        <p class="fw-bold text-success">
                                            <i class="fa-solid fa-circle-check"></i>
                                            使用中
                                        </p>
                                    </div>
                                    <div class="col-9">
                                        <p class="title text-primary mb-2">通常の買い物で使用するカード</p>
                                        <p>カードの種類｜<strong>{{ $use_card->brand }}</strong></p>
                                        <p>カード番号｜<strong>**** **** **** {{ $use_card->last4_number }}</strong></p>
                                        <p>有効期限｜<strong>{{ $use_card->custom_exp }}</strong></p>
                                    </div>
                                @else
                                    <div class="col-3 border-end text-center">
                                        <i class="fa-4x fa-solid fa-triangle-exclamation"></i>
                                        <p class="fw-bold">No Card</p>
                                    </div>
                                    <div class="col-9">
                                        <h5 class="title">カードがありません</h5>
                                        <small>
                                            「支払い情報設定」よりクレジットカードを追加してください
                                        </small>
                                    </div>
                                @endif
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 card card-body shadow">
                        <a href="{{ route('mypage.edit_info') }}" class="mypage-btn d-flex justify-content-between align-items-center my-auto">
                            <span class="pe-2">
                                <i class="fa-4x fa-solid fa-user-pen"></i>
                            </span>
                            <span class="w-100">
                                <p class="title mb-2">会員情報設定</p>
                                <small>名前、住所、電話番号等の変更</small>
                            </span>
                        </a>
                    </div>
                    <div class="col-6 card card-body shadow">
                        <a href="{{ route('mypage.edit_password') }}" class="mypage-btn d-flex justify-content-between align-items-center my-auto">
                            <span class="pe-2">
                                <i class="fa-4x fa-solid fa-unlock"></i>
                            </span>
                            <span class="w-100">
                                <p class="title mb-2">パスワード設定</p>
                                <small>ログインパスワードの変更</small>
                            </span>
                        </a>
                    </div>
                    <div class="col-6 card card-body shadow">
                        <a href="{{ route('verify.index', ['type' => 'customer']) }}" class="mypage-btn d-flex justify-content-between align-items-center my-auto">
                            <span class="pe-2">
                                <i class="fa-4x fa-solid fa-credit-card"></i>
                            </span>
                            <span class="w-100">
                                <p class="title mb-2">支払い情報設定</p>
                                <small>クレジットカードの追加、変更等</small>
                            </span>
                        </a>
                    </div>
                    <div class="col-6 card card-body shadow">

                        @if($use_card)
                            @if($user->role->id === 2)
                                @if($user->cancel_flag)
                                    <div class="d-flex justify-content-between align-items-center text-disabled">
                                        <span class="pe-2">
                                            <i class="fa-4x fa-solid fa-address-card"></i>
                                        </span>
                                        <span class="w-100">
                                            <p class="title mb-2">有料会員への変更</p>
                                            <small>現在登録不可 ( {{ $next_payment_at }} まで )</small>
                                        </span>
                                    </div>
                                @else
                                    <a href="{{ route('verify.index', ['type' => 'cancel_subscription']) }}" class="mypage-btn d-flex justify-content-between align-items-center my-auto">
                                        <span class="pe-2">
                                            <i class="fa-4x fa-solid fa-person-walking-dashed-line-arrow-right"></i>
                                        </span>
                                        <span class="w-100">
                                            <p class="title mb-2">有料会員の解約</p>
                                            <small>月額登録の解約手続き</small>
                                        </span>
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('verify.index', ['type' => 'subscription']) }}" class="mypage-btn d-flex justify-content-between align-items-center my-auto text-tertiary">
                                    <span class="pe-2">
                                        <i class="fa-4x fa-solid fa-address-card"></i>
                                    </span>
                                    <span class="w-100">
                                        <p class="title mb-2">有料会員への変更</p>
                                        <small>月額￥300円でアップグレード可能</small>
                                    </span>
                                </a>
                            @endif
                        @else
                            <div class="d-flex justify-content-between align-items-center text-disabled">
                                <span class="pe-2">
                                    <i class="fa-4x fa-solid fa-address-card"></i>
                                </span>
                                <span class="w-100">
                                    <p class="title mb-2">有料会員への変更</p>
                                    <small>登録可能なクレジットカードがありません</small>
                                </span>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="row justify-content-center mt-3">
                    <div class="col-md-10">
                        <div class="card card-body shadow">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" class="mypage-btn d-flex justify-content-center align-items-center my-auto">
                                <span class="pe-2">
                                    <i class="fa-4x fa-solid fa-door-open"></i>
                                </span>
                                <span class="w-50">
                                    <p class="title mb-2">ログアウト</p>
                                    <small>サインアウトする</small>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
    
            </div>
        </div>
    </div>
@endsection