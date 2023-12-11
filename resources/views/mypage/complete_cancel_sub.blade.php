@extends('layouts.app')

@section('title')
    解約完了｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <h5 class="title">有料会員の解約手続きが完了しました</h5>

                <p>無事に解約処理が完了致しました。</p>
                <p>なお、以下の残りの期間までの支払いは発生致しますのでご注意ください。</p>
                <h5 class="py-3 text-danger fw-bold">
                    {{ $format_end_date }} まで利用可能
                </h5>
                <p>ご利用ありがとうございました。</p>
            </div>
        </div>
    </div>
@endsection
