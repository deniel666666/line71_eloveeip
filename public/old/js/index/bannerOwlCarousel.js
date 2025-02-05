$(document).ready(function() {
    // bannerOwlCarouselRow  start /////////////////////////////////////////////////////////////////////////////////


    $('.bannerOwlCarouselRow .owl-carousel').owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        items: 1,
        autoplay: true,
        autoplayTimeout: 4500,
        autoplayHoverPause: true,
        smartSpeed: 650,

        // lazyLoad: true,
        // navText:["<div class='nav-btn prev-slide icon-left_arrow'></div>","<div class='nav-btn next-slide icon-right_arrow'></div>"],
    })

    // threeSquareAdRow  start /////////////////////////////////////////////////////////////////////////////////
    $('.threeSquareAdRow .owl-carousel').owlCarousel({
        loop: false,
        // margin: 12,
        nav: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 4500,
        autoplayHoverPause: true,
        smartSpeed: 1000,
        responsive: {
            0: {
                items: 1,
                stagePadding: 60,
                center: true,
                loop: true,
                margin: 6,
            },
            414: {
                items: 1,
                stagePadding: 75,
                center: true,
                loop: true,
                margin: 6,
            },
            576: {
                items: 1,
                stagePadding: 120,
                center: true,
                loop: true,
                margin: 6,
            },
            767: {
                items: 3,
                stagePadding: 0,
                center: false,
                loop: false,
                margin: 12,
            },
        }

    })
    // productListRow  start /////////////////////////////////////////////////////////////////////////////////
    $('.productListRow.hotsale  .owl-carousel').owlCarousel({
        loop: false,
        dots: false,
        autoplay: false,
        autoplayTimeout: 4500,
        stagePadding: 15,
        margin:15,
        autoplayHoverPause: true,
        smartSpeed: 1000,
        responsive: {
            0: {
                items: 1,
                loop: false,
                dots: true,
                nav: false,
            },
            414: {
                items: 2,
                loop: false,
                dots: true,
                nav: false,
            },
            768: {
                items: 2,
                loop: false,
                dots: true,
                nav: false,
            },
            991: {
                items: 3,
                loop: false,
                nav: true,
            },
            1440: {
                items: 5,
                loop: false,
                nav: true,
            },
            1920: {
                items: 5,
                loop: false,
                nav: true,
            },
        },
         navText: ["<i class='bi bi-chevron-left'></i>", "<i class='bi bi-chevron-right'></i>"],
    })

    $('.productListRow .owl-carousel').owlCarousel({
        loop: false,
        nav: true,
        dots: false,
        stagePadding: 30,
        margin:15,
        autoplay: true,
        autoplayTimeout: 4500,
        autoplayHoverPause: true,
        smartSpeed: 1000,
        responsive: {
            0: {
                items: 1,
                stagePadding: 0,
                center: false,
                dots: true, nav: false,
                loop: false,
            },
            414: {
                items: 2,
                stagePadding: 0,
                center: false,
                loop: false,
                nav: false,
                dots: true,
            },
            991: {
                items: 3,
                stagePadding: 0,
                center: false,
                loop: false,
            },
            1440: {
                items: 4,
                stagePadding: 0,
                center: false,
                loop: false,
            },
        },
        navText: ["<div class='nav-btn prev-slide fas fa-chevron-left'></div>", "<div class='nav-btn next-slide fas fa-chevron-right'></div>"],
    })

    
    


});
