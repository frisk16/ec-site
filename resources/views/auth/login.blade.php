@extends('layouts.app')

@section('title')
    ログイン｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">

            <h5 class="title">ログイン</h5>

            <div class="card card-body shadow">
                <form method="post" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row justify-content-center mt-3">
                        <label for="email" class="col-md-10 col-form-label">Eメールアドレス</label>

                        <div class="col-md-10">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                    </div>

                    <div class="form-group row justify-content-center mt-3">
                        <label for="password" class="col-md-10 col-form-label">パスワード</label>

                        <div class="col-md-10">
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                        </div>

                        @if($errors->any())
                        <div class="form-group d-flex justify-content-center text-danger mt-3">
                            <small>Eメールアドレス、又はパスワードが正しくありません</small>
                        </div>
                        @endif

                    </div>


                    <div class="form-group row justify-content-center mt-5 mb-3">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary w-100">ログイン</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mt-5 text-center">
                <p>※登録はこちらから</p>
                <a href="{{ route('register') }}" class="btn btn-success w-100">会員登録申請</a>
            </div>

            @if (Route::has('password.request'))
            <div class="text-center mt-3">
                <a class="btn btn-link" href="{{ route('password.request') }}">パスワードを忘れた方はこちら</a>
            </div>
            @endif


        </div>
    </div>
</div>
@endsection
