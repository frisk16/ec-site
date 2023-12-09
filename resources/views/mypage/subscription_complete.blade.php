@extends('layouts.app')

@section('title')
    登録完了｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <h5 class="title">登録完了</h5>
                <p>お疲れさまです、有料会員登録の手続きが完了しました。</p>
                <p>有料会員の支払いは１ヶ月毎にクレジットカードから自動引き落としさせて頂きます。</p>
                <p>なお、最初の支払いは登録直後から発生致します、ご注意ください。</p>
                <h5 class="mt-3">※登録内容は以下の通りです。</h5>

                <hr>
                <h4 class="mt-3">
                    <p>月額料金：<strong class="text-success">￥300円</strong></p>
                    <p>次回支払日：<strong class="text-danger">{{ $next_payment_day }}</strong></p>
                </h4>
                <hr>
                <p>引き続きよろしくお願い致します。</p>
            </div>
        </div>
    </div>
@endsection
