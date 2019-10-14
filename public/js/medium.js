$(document).ready(function () {

    // Submit queue form
    $('#queue-form').on('submit', function (e) {
        $.ajax({
            type: 'POST',
            url: '/queue',
            data: $(this).serialize(),
            success: function (response) {
                // data = $.parseJSON(response);
                // alert(data.status);
                if (response == 'true') {
                    
                } else {
                    
                }

            }
        });
        e.preventDefault();
    });

})