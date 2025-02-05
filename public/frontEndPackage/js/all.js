$(function () {

    var Slider = $('.slider');

    var ServiceLink = $('.pro-service-item');

    var Case = $('.case-box')

    

    

    Slider.slick({

        dots: true,

        infinite: true,

        autoplay: true,

        speed: 500,

        autoplaySpeed: 3000,

        cssEase: 'linear',

    });

    ServiceLink.slick({

            

            infinite: true,

            autoplay:true,

            speed: 300,

            slidesToShow: 4,

            slidesToScroll: 1,

            responsive: [{

                breakpoint: 1200,

                    settings: {

                        slidesToShow: 3,

                        slidesToScroll: 1,

                        infinite: true,

                    }

                }, {

                    breakpoint: 992,

                    settings: {

                        slidesToShow: 2,

                        slidesToScroll: 1,

                    }

                }, {

                    breakpoint: 768,

                    settings: {

                        slidesToShow: 1,

                        slidesToScroll: 1,

                    }

                }

            ]

    });

    

    Case.slick({

        arrows: false,

        infinite: true,

        speed: 300,

        autoplay: true,

        autoplaySpeed: 3000,

        slidesToShow: 6,

        slidesToScroll: 1,

        responsive: [{

            breakpoint: 992,

            settings: {

                slidesToShow: 4,

                slidesToScroll: 4,

            }

        }, {

            breakpoint: 768,

            settings: {

                slidesToShow: 3,

                slidesToScroll: 3,

            }

        }, {

            breakpoint: 512,

            settings: {

                slidesToShow: 2,

                slidesToScroll: 2,

            }

        }]

    });



    



    //gotop

    $("#gotop").click(function () {

        jQuery("html,body").animate({

            scrollTop: 0

        }, 1000);

    });

    $(window).on("scroll", function () {

        var scrollTop = $(window).scrollTop();



        if (scrollTop > 300) {



            $('#gotop').fadeIn(500);

        } else {



            $('#gotop').stop().fadeOut(500);

        }



    });



    // 跑馬燈

    jQuery(function ($) {

        setInterval(function () {

            var marquee = $("#announcementCarousel");

            marquee.stop().animate({

                scrollLeft: marquee.children(":first").width()

            }, {

                duration: "slow", 

                complete: function () {

                    marquee.scrollLeft(0).children(":first").appendTo(marquee);

                }

            });

        }, 4500);

    });



    $('.m-classLink a.all-btn').click(function () {

        if ($(this).hasClass('open')) {

            $(this).removeClass('open').parents('.m-classLink').find('ul.slideLink').stop().slideUp(200);

            $(this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');

        } else {

            $(this).addClass('open').parents('.m-classLink').find('ul.slideLink').stop().slideDown(200);

            $(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up');

        }





    });



    $('.m-classLink ul li a').on('click', function () {

        $(this).parent().addClass('active');

        $(this).parent().siblings().removeClass('active');

    });


    // 點擊向右滑
    $(".online-page  .slide_right").click(function () {
        var leftPos = $('.scroll_box ul').scrollLeft();
        $(".scroll_box ul").animate({
            scrollLeft: leftPos + 380
        }, 800);
    });
    // 點擊向左滑
    $(".online-page .slide_left").click(function () {
        var leftPos = $('.scroll_box ul').scrollLeft();
        $(".scroll_box ul").animate({
            scrollLeft: leftPos - 380
        }, 800);
    });

});