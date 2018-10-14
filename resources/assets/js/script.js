(function ($) {
    $(document).ready(function () {
        $("#comment-btn").click(function () {
            $("#comment-form").fadeToggle();
        });
    });
}(jQuery));


export function alertError(message){
    let errorAlert = $('#error-alert');
    errorAlert.show();
    errorAlert.fadeOut(1000 * 10);
    $('#error-msg').html(message);
}

export function alertSuccess(message){
    let successAlert = $('#success-alert');
    successAlert.show();
    successAlert.fadeOut(1000 * 10);
    $('#success-msg').html(message);
}