@extends('layouts.app')

@section('title')
    クレジットカード照会｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <div class="container">

        <h5 class="title">支払い情報の追加、削除</h5>

        <div class="row justify-content-center">
            <div class="col-md-8 mb-5 card-area">
                @if($user->customers()->exists())
                    @foreach($user->customers()->get() as $customer)
                        <div class="card-views">
                            <div class="card shadow">
                                <div class="card-header bg-primary d-flex justify-content-between">
                                    <p>{{ $customer->brand }}カード</p>
                                    <p>登録日｜{{ $customer->created_at }}</p>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-3 text-end">
                                            <i class="fa-4x {{ $customer->brand_icon }}"></i>
                                        </div>
                                        <div class="col-9">
                                            @if($customer->enabled)
                                                <span class="text-success">
                                                    <i class="fa-solid fa-circle-check"></i>
                                                    使用中
                                                </span>
                                            @else
                                                <span class="text-secondary">
                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                    未使用
                                                </span>
                                            @endif
                                            <h6>番号｜**** **** **** {{ $customer->last4_number }}</h6>
                                            <p>利用期限｜{{ $customer->exp }}</p>
                                            <div class="d-flex justify-content-end align-items-center mt-3">
                                                <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-card-modal{{ $customer->id }}">削除する</a>
                                                @if(!$customer->enabled)
                                                    <p class="fw-bold fs-5">｜</p>
                                                    <form action="{{ route('customers.update_enabled', $customer) }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <button type="submit" class="btn btn-primary btn-sm">使用する</button>
                                                    </form>
                                                @endif

                                                {{-- Delete Card Modal --}}
                                                <div class="modal fade" id="delete-card-modal{{ $customer->id }}" tabindex="-1" data-keyboard="false">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="modal-title d-flex align-items-center">
                                                                    <i class="me-3 fa-2x {{ $customer->brand_icon }}"></i>
                                                                    選択中のカードを削除しますか？
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="{{ route('customers.destroy', $customer) }}" method="post">
                                                                    @csrf
                                                                    @method('delete')

                                                                    <span class="btn btn-secondary btn-sm" data-bs-dismiss="modal">閉じる</span>
                                                                    <button type="submit" class="btn btn-danger btn-sm">削除</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="d-flex justify-content-center text-center text-secondary">
                        <h5 class="pt-5">
                            <i class="fa-5x fa-solid fa-credit-card"></i>
                            <p class="mt-3">カードがありません</p>
                        </h5>
                    </div>
                @endif
            </div>
            <div class="col-md-4 item-area">
                @if($user->customers()->exists())
                    @foreach($user->customers()->get() as $customer)
                        <div class="card-items" data-enabled="{{ $customer->enabled }}">
                            <div class="card card-body shadow mb-2">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-10">
                                        <strong>
                                            <i class="fa-2x fa-solid fa-credit-card"></i>
                                            {{ $customer->brand }}
                                        </strong>
                                        <p>登録日：{{ $customer->created_at }}</p>
                                    </div>
                                    <div class="col-2">

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                <hr>

                @if($user->last_name == null || $user->first_name == null)
                    <button class="btn btn-secondary disabled">カード情報の追加</button>
                    <p class="text-danger fw-bold mt-3">※先に会員情報の登録を完了させてください</p>
                @else
                    @if($user->customers()->get()->count() < 2)
                        <form action="{{ route('customers.store') }}" method="post">
                            @csrf
                            <script
                                src="https://checkout.stripe.com/checkout.js"
                                class="stripe-button"
                                data-key="{{ config('stripe.public_key') }}"
                                data-name="カード登録"
                                data-label="カード情報の追加"
                                data-description="クレジットカード登録"
                                data-email="{{ $user->email }}"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                data-locale="auto"
                                data-currency="JPY"
                                data-panelLabel="登録"
                            >
                            </script>
                        </form>
                        <p class="text-success fw-bold mt-3">※最大2枚まで追加可能</p>
                    @else
                        <button class="btn btn-secondary disabled">カード情報の追加</button>
                        <p class="text-danger fw-bold mt-3">※これ以上は追加できません</p>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/creditCard.js') }}"></script>
@endsection
