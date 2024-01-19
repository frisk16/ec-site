@if($errors->any() || session('error_password'))
<div class="msg msg-error">
    <i class="fa-4x fa-solid fa-triangle-exclamation"></i>
    <p class="mt-3">入力内容に誤りがあります</p>
</div>
@endif

@if(session('disabled_user'))
<div class="msg msg-error">
    <i class="fa-4x fa-solid fa-triangle-exclamation"></i>
    <p class="mt-3">{{ session('disabled_user') }}</p>
</div>
@endif

@if(session('error_msg'))
<div class="msg msg-error">
    <i class="fa-4x fa-solid fa-triangle-exclamation"></i>
    <p class="mt-3">{{ session('error_msg') }}</p>
</div>
@endif

@if(session('success_msg'))
<div class="msg msg-success">
    <i class="fa-4x fa-regular fa-circle-check"></i>
    <p class="mt-3">{{ session('success_msg') }}</p>
</div>
@endif

@if(session('cart_msg'))
<div class="msg msg-success">
    <i class="fa-4x fa-solid fa-cart-plus"></i>
    <p class="mt-3">{{ session('cart_msg') }}</p>
</div>
@endif
