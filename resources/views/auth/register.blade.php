@extends('layouts.app')

@section('title')
    会員登録｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <h5 class="title">会員登録</h5>

            <div class="card card-body shadow">
                <form method="post" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group row mt-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Eメールアドレス</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">パスワード</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">パスワード（確認用）</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row justify-content-center mt-5">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary w-100">登録メール送信</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
