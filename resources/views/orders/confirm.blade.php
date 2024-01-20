@extends('layouts.app')

@section('title')
    注文内容の確認｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')

<div class="container">
    <form action="{{ route('orders.store') }}" method="post">
        @csrf
        <div class="row justify-content-center">
    
            <div class="col-lg-8">
                <h3 class="title text-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    まだ注文は確定していません
                </h3>
                <div class="card shadow mb-5">
                    <div class="card-header bg-senary">
                        @if(request()->des === 'about')
                        <h5 class="my-1">別のお届け先を指定</h5>
                        @else
                        <h5 class="my-1">お届け先の確認</h5>
                        @endif
                    </div>
                    <div class="card-body">
                        @if(request()->des === 'about')

                        <input type="hidden" name="des" value="about">
                        <div class="container-fluid">
                            <div class="row mb-3">
                                <label for="des_name" class="col-form-label col-lg-4 text-lg-end">
                                    受け取り人のお名前
                                </label>
                                <div class="col-lg-8">
                                    <input type="text" name="des_name" id="des_name" class="form-control @error('des_name') is-invalid @enderror" placeholder="フルネーム" value="{{ old('des_name') }}">
                                
                                    @error('des_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="des_postal_code" class="col-form-label col-lg-4 text-lg-end">
                                    郵便番号
                                </label>
                                <div class="col-lg-8">
                                    <input type="text" name="des_postal_code" id="des_postal_code" class="form-control @error('des_postal_code') is-invalid @enderror" placeholder="半角数字ハイフン無し" pattern="[0-9]*" value="{{ old('des_postal_code') }}">
                                
                                    @error('des_postal_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="des_address" class="col-form-label col-lg-4 text-lg-end">
                                    住所
                                </label>
                                <div class="col-lg-8">
                                    <input type="text" name="des_address" id="des_address" class="form-control @error('des_address') is-invalid @enderror" placeholder="○○県 ××市 △△区 00-00" value="{{ old('des_address') }}">
                                
                                    @error('des_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="des_phone_number" class="col-form-label col-lg-4 text-lg-end">
                                    連絡先番号
                                </label>
                                <div class="col-lg-8">
                                    <input type="text" name="des_phone_number" id="des_phone_number" class="form-control @error('des_phone_number') is-invalid @enderror" placeholder="半角数字ハイフン無し" pattern="[0-9]*" value="{{ old('des_phone_number') }}">
                                
                                    @error('des_phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 text-end">
                                    <a href="{{ route('orders.confirm', ['token' => request()->token, 'des' => 'me']) }}" class="btn btn-success">ご自身の住所に変更</a>
                                </div>
                            </div>
                        </div>

                        @else
    
                        <input type="hidden" name="des" value="me">
                        <div class="container px-lg-5">
                            <div class="mb-3">
                                <h5 class="title m-0">受け取り人のお名前</h5>
                                <strong class="ms-2">{{ $user->full_name }} 様</strong>
                                <input type="hidden" name="des_name" value="{{ $user->full_name }}">
                            </div>
                            <div class="mb-3">
                                <h5 class="title m-0">郵便番号</h5>
                                <strong class="ms-2">〒{{ $user->full_postal_code }}</strong>
                                <input type="hidden" name="des_postal_code" value="{{ $user->postal_code }}">
                            </div>
                            <div class="mb-3">
                                <h5 class="title m-0">住所</h5>
                                <strong class="ms-2">{{ $user->full_address }}</strong>
                                <input type="hidden" name="des_address" value="{{ $user->full_address }}">
                            </div>
                            <div class="mb-3">
                                <h5 class="title m-0">連絡先番号</h5>
                                <strong class="ms-2">
                                    <i class="fa-solid fa-phone"></i>
                                    {{ $user->phone_number }}
                                </strong>
                                <input type="hidden" name="des_phone_number" value="{{ $user->phone_number }}">
                            </div>
                            <div class="mb-3 text-end">
                                <a href="{{ route('orders.confirm', ['token' => request()->token, 'des' => 'about']) }}" class="btn btn-success">お届け先の変更</a>
                            </div>
                        </div>
                        
                        @endif 
                    </div>
                </div>

                <h5 class="title">注文内容の確認</h5>

                @foreach($carts as $cart)
                    @if($cart->product->public_flag)
                    <div class="row justify-content-center mt-3">
                        <div class="col-4 col-lg-3">
                            <a href="{{ route('products.show', $cart->product->id) }}">
                                <img src="{{ $storage->url($cart->product->image) }}" class="img-fluid">
                            </a>
                        </div>
                        <div class="col-8 col-lg-9">
                            <h5 class="title mb-0">{{ $cart->product->name }}</h5>
                            <p class="mb-3">追加日時：{{ $cart->created_at }}</p>
                            <h1 class="fs-4 mb-0 text-danger fw-bold">￥{{ number_format($cart->product->price) }}円<small>(税込)</small></h1>
                            <strong class="text-success">
                                <i class="fa-solid fa-truck"></i>
                                送料：
                                @if($cart->product->carriage_flag)
                                    ￥300円
                                @else
                                    無料
                                @endif
                            </strong>
                            <p class="fw-bold">
                                <i class="fa-solid fa-box-open"></i>
                                数量：{{ $cart->qty }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    @endif
                @endforeach

            </div>
    
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header bg-senary">
                        <h5 class="my-1">会計</h5>
                    </div>
                    <div class="card-body">
                        <div class="mt-3">
                            <h5 class="title mb-0">総額</h5>
                            <h1 class="text-danger fs-3 fw-bold">￥{{ number_format($total_price) }}円</h1>
                            <input type="hidden" name="total_price" value="{{ $total_price }}">
                        </div>
                        <div class="mt-3">
                            <h5 class="fw-bold">
                                <i class="fa-solid fa-box-open"></i>
                                合計数量：{{ $total_qty }}
                                <input type="hidden" name="total_qty" value="{{ $total_qty }}">
                            </h5>
                        </div>
                        <div class="mt-3">
                            <h5>
                                <i class="fa-solid fa-truck"></i>
                                送料：
                                <strong class="text-success fs-5">
                                    @if($carriage)
                                    ￥300円
                                    <input type="hidden" name="carriage" value="300">
                                    @else
                                    無料
                                    <input type="hidden" name="carriage" value="0">
                                    @endif
                                </strong>
                            </h5>
                        </div>
                        <div class="mt-3">
                            <div class="card card-body">
                                <h5 class="title">お支払い方法</h5>
                                @if($credit)
                                <div class="row">
                                    <div class="col-4 text-end">
                                        <i class="fa-4x {{ $credit->brand_icon }}"></i>
                                    </div>
                                    <div class="col-8">
                                        <h5 class="title mb-0">{{ $credit->brand }}</h5>
                                        <p class="fw-bold">**** **** **** {{ $credit->last4_number }}</p>
                                        <p>有効期限：{{ $credit->custom_exp }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="mt-3">
                            <input type="hidden" name="token" value="{{ request()->token }}">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa-solid fa-check"></i>
                                注文を確定する
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>
    </form>
</div>

@endsection