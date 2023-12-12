@extends('layouts.app')

@section('title')
    本人確認｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <h5 class="title">本人確認</h5>

                <div class="card card-body shadow">
                    <form action="{{ route('verify.token') }}" method="post">
                        @csrf

                        <input type="hidden" name="type" value="{{ request()->type }}">
                        <div class="form-group row justify-content-center mt-3">
                            <label for="" class="col-form-label col-md-10">
                                Eメールアドレス
                            </label>
                            <div class="col-md-10">
                                {{ Auth::user()->email }}
                            </div>
                        </div>
                        <div class="form-group row justify-content-center mt-3">
                            <label for="password" class="col-form-label col-md-10">
                                パスワードを入力
                            </label>
                            <div class="col-md-10">
                                <input type="password" name="password" id="password" class="form-control @if(session('error_password')) is-invalid @endif" placeholder="現在のパスワード" required>

                                @if(session('error_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ session('error_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row justify-content-center mt-5">
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-primary w-100">確認</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
