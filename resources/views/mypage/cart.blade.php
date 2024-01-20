@extends('layouts.app')

@section('title')
    ショッピングカート｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">

        <div class="col-lg-4 mb-5">
            <div class="card shadow">
                <div class="card-header bg-senary">
                    <h5 class="my-1">ショッピングカート</h5>
                </div>
                <div class="card-body">
                    <div class="mt-3">
                        <h5 class="title mb-0">小計</h5>
                        <h1 class="text-danger fs-3 fw-bold">￥{{ number_format($sub_total_price) }}円</h1>
                    </div>
                    <div class="mt-3">
                        <h5 class="fw-bold">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            全{{ $carts->count() }}商品が入っています
                        </h5>
                    </div>
                    @if($carts->first())
                    <div class="mt-3">
                        <h5>
                            <i class="fa-solid fa-truck"></i>
                            送料：
                            <strong class="text-success fs-5">
                                @if($carriage)
                                ￥300円
                                @else
                                無料
                                @endif
                            </strong>
                        </h5>
                    </div>
                    @endif
                    <div class="mt-3">
                        @if(Auth::user()->customers()->exists())
                        <a href="{{ route('verify.index', ['type' => 'order']) }}" class="btn btn-primary w-100 @if(!$carts->first()) disabled @endif)">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            購入手続きへ進む
                        </a>
                        @else
                        <span class="btn btn-secondary disabled w-100">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            クレジットカードが登録されていません
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            @if(Auth::user()->carts()->exists())
                <hr>
                @foreach($carts as $cart)

                <div class="row justify-content-center mt-3">
                    <div class="col-4 col-lg-3">
                        <a href="{{ route('products.show', $cart->product->id) }}" @if(!$cart->product->public_flag) onClick="return false;" @endif>
                            @if($cart->product->image)
                            <img src="{{ $storage->url($cart->product->image) }}" class="img-fluid">
                            @else
                            <img src="{{ asset('images/dummy.png') }}" alt="" class="img-fluid">
                            @endif
                        </a>
                    </div>
                    <div class="col-8 col-lg-9">

                        @if($cart->product->public_flag)
                        <h5 class="title mb-0">{{ $cart->product->name }}</h5>
                        @else
                        <p class="fw-bold text-danger">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            現在購入できません
                        </p>
                        <h5 class="title mb-0 text-secondary">{{ $cart->product->name }}</h5>
                        @endif

                        <p class="mb-3">追加日時：{{ $cart->created_at }}</p>

                        @if($cart->product->public_flag)
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
                        @endif

                        <div class="row justify-content-between align-items-center mt-3">
                            <div class="col-lg-6">
                                <form action="{{ route('carts.update', $cart) }}" method="post" class="row align-items-center">
                                    @csrf
                                    @method('put')
                                    <div class="form-group col-4 col-md-3 col-lg-4 col-xl-3 pe-0">
                                        <select name="qty" id="qty" class="form-select form-select-sm">
                                            @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}"@if($i === $cart->qty) selected @endif>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group col-8 col-md-5 col-lg-7 col-xl-6">
                                        <button type="submit" class="btn btn-success btn-sm w-100" @if(!$cart->product->public_flag) onClick="return false;" @endif>
                                            <i class="fa-solid fa-cart-arrow-down"></i>
                                            数量を変更
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-6 text-end mt-2 mt-lg-0">
                                <form action="{{ route('carts.destroy', $cart) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                        削除
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                @endforeach
            @else
                <h5 class="py-5 text-center text-secondary">
                    <i class="fa-5x fa-solid fa-basket-shopping"></i>
                    <p class="mt-3">商品が入ってません</p>
                </h5>
            @endif
        </div>
    </div>
</div>

@endsection