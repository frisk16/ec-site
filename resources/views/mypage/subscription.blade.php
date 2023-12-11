@extends('layouts.app')

@section('title')
    有料会員手続き｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <h5 class="title">有料会員登録手続き</h5>

                <p><span class="fw-bold text-danger">月額￥300円</span>からお申し込み頂けるプランです。</p>
                <p>支払い方法を以下の登録済みカードから選択してください。</p>

                <p class="text-danger fw-bold mt-3">※注意</p>
                <ul class="text-primary">
                    <li>月額払いで使用するカードは、有料会員登録中は削除できなくなります、ご注意ください</li>
                </ul>

                <form action="{{ route('subscriptions.register') }}" method="post" class="d-flex flex-column">
                    @csrf

                    @foreach($customers as $customer)
                        <label for="{{ $customer->id }}" class="card-items">
                            <div class="card shadow mt-3">
                                <div class="card-header bg-primary d-flex justify-content-between">
                                    <p>{{ $customer->brand }}カード</p>
                                    <p>登録日｜{{ $customer->created_at }}</p>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-3 text-end">
                                            <input type="radio" name="customer_id" id="{{ $customer->id }}" value="{{ $customer->id }}" class="d-block" @if($customer->enabled) checked @endif>
                                            <i class="fa-4x {{ $customer->brand_icon }}"></i>
                                        </div>
                                        <div class="col-9">
                                            @if($customer->enabled)
                                            <p class="text-success">
                                                <i class="fa-solid fa-triangle-exclamation"></i>
                                                通常のショッピングで使用中
                                            </p>
                                            @endif
                                            <h6>番号｜**** **** **** {{ $customer->last4_number }}</h6>
                                            <p>利用期限｜{{ $customer->exp }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    @endforeach

                    <div class="form-group mt-5">
                        <button type="submit" class="btn btn-danger w-100">選択したカードで登録する</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
