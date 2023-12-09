@extends('layouts.app')

@section('title')
    確認メール送信｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h5 class="title">確認メールを送信しました</h5>

            <p>先程入力したEメールアドレス宛に確認メールを送信しました、ご確認ください。</p>
            <p>もしメールが届いてない場合は以下のボタンをクリックして再度確認メールを再発行してください。</p>
            <div class="card card-body text-center shadow mt-5">
                <form action="{{ route('verification.send') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary w-50">確認メール再発行</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
