$(document).ready(function() {

    $('#rating__form').submit(function(e){
        e.preventDefault()

        $.ajax({
            type: "POST",
            url: "",
            dataType: 'json',
            data: $(this).serialize(),
            success: function(msg){
                if(msg.SUCCESS){
                    $('.rating__success-answer').text(msg.SUCCESS).show(300)
                    location.reload()
                    // setTimeout(function(){
                    //     $('.rating__success-answer').hide(300)
                    // }, 3000)
                }
            //   alert( "Прибыли данные: " + msg );
            }
        });
    })

});
