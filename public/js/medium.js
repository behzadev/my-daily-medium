$(document).ready(function () {

    // Submit queue form
    $('#queue-form').on('submit', function (e) {
        $.ajax({
            type: 'POST',
            url: '/queue',
            data: $(this).serialize(),
            success: function (response) {
                if (response.status == 'success') {
                    swal(
                        '',
                        'Article queued successfully',
                        'success'
                      );
                } else {
                    swal(
                        '',
                        'Queue failed :(',
                        'error'
                      );
                }
            }
        });
        e.preventDefault();
    });

})