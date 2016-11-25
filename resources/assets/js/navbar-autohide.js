/**
 * Created by al_imran on 11/25/16.
 */
(function ($) {
    $(document).ready(function () {
        var topNavBar = $("#top-navbar");
        // hide .navbar first
        //topNavBar.fadeOut("slow");

        // fade in .navbar
        /*$(function () {
            $(window).scroll(function () {
                // set distance user needs to scroll before we fadeIn navbar
                if ($(this).scrollTop() > 50) {
                    topNavBar.fadeIn();
                } else {
                    topNavBar.fadeOut();
                }
            });
        });*/

        //Show navabar when mouse is at the top of window
        $(function() {
            var mouseY = 0;
            document.addEventListener('mousemove', function(e) {

                mouseY = e.clientY || e.pageY;

                if(mouseY > 100 && !topNavBar.is(':hover')) {
                    topNavBar.fadeOut();

                }else{
                    topNavBar.fadeIn();

                }
            }, false);
        });
    });
}(jQuery));
