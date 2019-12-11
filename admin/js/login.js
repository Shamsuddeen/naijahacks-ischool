$(document).ready(function () {
    $("#loader").hide();
    $('.LoginForm').on('submit', function (e) {
        $("#loader").show();
        $.ajax({
            type: 'post',
            url: 'signin.php',
            data: $(this).serialize(),
            success: function (msg) {
                $('#regInfo').html(msg);
                $("#loader").hide();
                $('.LoginForm').each(function(){
                    // this.reset();
                });
            }
        });
        e.preventDefault();
    });
});