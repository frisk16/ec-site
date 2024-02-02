$(function() {
    let btn = $('.fav-btn');
    btn.on('click', function() {
        let $this = $(this);
        let productId = $this.data('product-id');
        let csrfToken = $this.data('csrf-token');
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });
        $.ajax({
            url: `${location.host}/favorites/json_toggle`,
            type: 'POST',
            cache: false,
            dataType: 'json',
            data: {
                'product_id': productId,
            },
        })
        .done(function(data) {
            if(data.success == true) {
                $this.toggleClass('fav-heart');
            }
        })
        .fail(function() {
            alert('Error: お気に入り');
        });
    });
});