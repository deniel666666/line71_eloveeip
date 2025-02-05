        function memberToggle() {
            $(".memberToggle").click(function() {
                var width_toggle = Modernizr.mq('(max-width: 991px)');
                if (width_toggle) {
                    $(".memberMwnu").slideUp(200);
                    $(".memberToggle").removeClass("active");
                    if (!$(this).next().is(":visible")) {
                        $(this).next().slideDown(200);
                        $(".memberToggle").addClass("active");
                    }
                }
            })
        }
        memberToggle();
        function memberMwnuDiplay() {
            var width_toggle = Modernizr.mq('(max-width: 991px)');
            if (width_toggle) {
                $(".memberMwnu").slideUp(200);
                if (!$(this).next().is(":visible")) {
                    $(this).next().slideDown(200);
                }
                $(".memberToggle").removeClass("active");
            }else{
                $(".memberMwnu").slideDown(200);
                $(".memberToggle").addClass("active");
            }
        }
        $(window).on("resize", function() {
            memberMwnuDiplay();
        }).resize();