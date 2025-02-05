    // $('.menuTrigger').click(function() {
    $('.burger-menu').click(function() {
        $('.mainPanel').toggleClass('isOpen');
        $('.wrapper').toggleClass('pushed');
        $(".burger-menu").toggleClass("menu-on"); //add
    });

    $('.closeSubPanel').click(function() {
        $('.mainPanel').removeClass('isOpen');
        $('.proInfoPanel').removeClass('isOpen');
        $('.wrapper').removeClass('pushed');
        $(".burger-menu").removeClass("menu-on"); //add
        $("body").removeClass("on-side");
    });

    $('.closePanel').click(function() {
        $('.mainPanel').removeClass('isOpen');
        $('.wrapper').removeClass('pushed');
        $(".burger-menu").removeClass("menu-on"); //add
        $("body").removeClass("on-side");
    });





   
    //  產品資訊
    $(window).on("resize", function() {
        var width992 = Modernizr.mq('(min-width: 992px)');
        if (width992) {
            $('.mainPanel').removeClass('isOpen');
            $('.proInfoPanel').removeClass('isOpen');
            $('.wrapper').removeClass('pushed');
            $(".burger-menu").removeClass("menu-on"); //add
            $('body').removeClass('on-side');
            vue_phone_menuVM.clearLayerRecord();
        }
    }).resize();

 

    

 




    