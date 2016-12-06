(function ($) {
    $(document).ready(function () {
        $("#comment-btn").click(function(){
            $("#comment-form").fadeToggle();
        });

    });
    function showCategoryForm(){
        $("#category-form").modal('show');
    }
}(jQuery));