@extends('layouts.app')

@section('title')
    パスワード再設定｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <h5 class="title">パスワード再設定</h5>

            <div class="card card-body shadow">
                <form action="{{ route('password.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="row form-group mt-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">
                            Eメールアドレス
                        </label>
                        <div class="col-md-6">
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="登録中のEメールアドレス" required>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group mt-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">
                            新しいパスワード
                        </label>
                        <div class="col-md-6">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="半角英数字記号8文字以上" required>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group mt-3">
                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">
                            新しいパスワード(確認用)
                        </label>
                        <div class="col-md-6">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="確認の為再度入力" required>
                        </div>
                    </div>
                    <div class="row justify-content-center form-group mt-5">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary w-100">パスワード更新</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
