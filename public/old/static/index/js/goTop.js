    // go top
    var Global = {
        init: function() {
            Global.scroll();
        },

        scroll: function() {
            // Show or hide the sticky footer button
            $(window).scroll(function() {
                if ($(this).scrollTop() > 200) {
                    $('.goTop').fadeIn(200);
                    $('.goTop').css('display','flex');
                } else {
                    $('.goTop').fadeOut(200);
                }

                //  sticky 購物車
                var top = $(this).scrollTop();
                var height = $('header').outerHeight() + $('.directoryRow').outerHeight() + $('.page-banner').outerHeight();

                if (top > height - 100) {
                    $('.accordion').addClass('sticky');
                   
                } else {
                    $('.accordion').removeClass('sticky');
                }
            });


            // Animate the scroll to top
            $('.goTop').click(function(event) {
                event.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, 300);
            })
        }
    };




    document.addEventListener("DOMContentLoaded", function() {
        Global.init();
    });

$(".search-m a").click(function () {
    $(".phoneSearchBox").slideToggle();
});


