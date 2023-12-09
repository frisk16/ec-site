@extends('layouts.app')

@section('title')
    パスワード再設定手続き｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <h5 class="title">パスワード再設定手続き</h5>

            <div class="card card-body shadow">
                <form action="{{ route('password.email') }}" method="post">
                    @csrf

                    <div class="row form-group mt-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">
                            Eメールアドレス
                        </label>
                        <div class="col-md-6">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="登録中のEメールアドレス" required>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>そのEメールアドレスは現在登録されていません</strong>
                                </span>
                            @enderror

                            @if(session('status'))
                                <span class="text-success">
                                    <strong>
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        入力したEメールアドレス宛に再設定メールを送信しました、ご確認ください。
                                    </strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row justify-content-center form-group mt-5">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary w-100">再設定メールを送信</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
