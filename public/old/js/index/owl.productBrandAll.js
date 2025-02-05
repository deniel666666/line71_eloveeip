    // function resizedw() {
    //     var woonine = Modernizr.mq('(max-width: 991px)');
    //     var wnnone = Modernizr.mq('(max-width: 767px)');
    //     if (woonine) {
    //         var contentBoxW = $("#itemBox").width();
    //         contentBoxW = contentBoxW - 220; 
    //         $("#rightContentBox").innerWidth(contentBoxW);
    //         if (wnnone) {
    //             $("#rightContentBox").innerWidth("100%");
    //         }
    //     } else {
    //         var contentBoxW = $("#itemBox").width();
    //         contentBoxW = contentBoxW - 300; 
    //         $("#rightContentBox").innerWidth(contentBoxW);
    //     }
    // }
    // var doit; 
    // $(window).on('load scroll resize', function() {
    //     resizedw();
    // });
    // resizedw();


    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            loop: false,
            margin: 12,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 4500,
            autoplayHoverPause: true,
            smartSpeed: 1000,
            responsive: {
                0: {
                    items: 1,
                    stagePadding: 0,
                    center: false,
                    loop: false,
                    margin: 6,
                },
                414: {
                    items: 2,
                    stagePadding: 0,
                    center: false,
                    loop: false,
                    margin: 6,
                },
                1200: {
                    items: 3,
                    stagePadding: 0,
                    center: false,
                    loop: false,
                    margin: 12,
                },
            },
            navText: ["<div class='nav-btn prev-slide icon-left'></div>", "<div class='nav-btn next-slide icon-right'></div>"],
        })
    });