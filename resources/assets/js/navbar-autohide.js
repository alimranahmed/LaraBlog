/**
 * Created by al_imran on 11/25/16.
 */
(function ($) {
    $(document).ready(function () {
        // hide .navbar first
        $(".top-navbar").fadeOut("slow");

        // fade in .navbar
        $(function () {
            /*$(window).scroll(function () {
                // set distance user needs to scroll before we fadeIn navbar
                if ($(this).scrollTop() > 50) {
                    $('.top-navbar').fadeIn();
                } else {
                    $('.top-navbar').fadeOut();
                }
            });*/
        });

        $(function() {
            var mouseY = 0;
            document.addEventListener('mousemove', function(e) {
                console.log('MouseMoving: '+e.clientX+','+e.clientY);
                mouseY = e.clientY || e.pageY;
                if(mouseY < 100) {
                    $('.top-navbar').fadeIn();
                }else{
                    $('.top-navbar').fadeOut(1000 * 3);
                }
            }, false);
        });
    });
}(jQuery));
