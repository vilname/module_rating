$(document).ready(function() {

    $('.admin_rating__button-js').on('click', function(e){
        var order_id = $('.admin-rating__input-js').val() ? $('.admin-rating__input-js').val() : ''
        $.ajax({
            url: '',
            // dataType: 'json',
            data: {
                order_id,
                action: 'search-order'
            },
            success: function(html){
                $('.admin-rating__container-js').empty()
                $('.admin-rating__container-js').append(html)
                // console.log(html)
            }
        });
    })

});
