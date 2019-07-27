( function ( $ ) {

    $(document).ready(function(){

        $('.button').click(function(){
            $userName = $('#username').val();

            $.ajax({
                url: 'http://site.domain/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {'action': 'check_username', user_name: $userName},
                dataType: 'json',
                success: function(response) {
                    $('.message').text($userName + response.text);
                }
            });
        });
        
    });

} )( jQuery )