$(document).ready(function () {
    $("#loader").hide();
    $('.signup-from').on('submit', function (e) {
        $("#loader").show();
        $.ajax({
            type: 'post',
            url: 'signup.php',
            data: $(this).serialize(),
            success: function (msg) {
                $('#regInfo').html(msg);
                $("#loader").hide();
                $('.signup-from').each(function(){
                    this.reset();
                });
            }
        });
        e.preventDefault();
    });
});