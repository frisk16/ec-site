@extends('layouts.app')

@section('title')
    解約手続き｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <h5 class="title">有料会員解約手続き(月額払い解除)</h5>

                <h5 class="text-danger text-center py-3">※ご注意ください</h5>
                <ul>
                    <li class="mt-3">現在登録中のカードでの支払い期間が残っている場合は、解約後も残りの期間の支払いが発生致します。</li>
                    <li class="mt-3">解約後に再び有料会員へ登録する場合、解約前の残りの支払い期間が終了してからでないと再登録が行えません。</li>
                    <li class="mt-3">上記の内容を承諾後、以下のボタンより解約申請を行ってください。</li>
                </ul>
               
                <a href="#" data-bs-toggle="modal" data-bs-target="#delete-subscription-modal" class="btn btn-danger w-100 mt-5">内容を承諾の上、解約を行う</a>
            
                {{-- Delete Subscription Modal --}}
                <div class="modal fade" id="delete-subscription-modal" tabindex="-1" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="modal-title fw-bold text-danger">解約処理を行います、本当によろしいですか？</div>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('subscriptions.disabled') }}" method="post">
                                    @csrf

                                    <span class="btn btn-secondary btn-sm" data-bs-dismiss="modal">キャンセル</span>
                                    <button type="submit" class="btn btn-danger btn-sm">解約する</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection