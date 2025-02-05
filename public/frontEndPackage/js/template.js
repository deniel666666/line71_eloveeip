var ww = 0; /*螢幕寬度*/
var is_pc = true; /*是否為電腦版*/
function renew_is_pc() {
    ww = $(window).width();
    return ww >= 992; /*判斷是否為電腦版*/
}

function border_color_control(){
    $("[class*='bborder-#']").each(function () {
        class_list = $(this).attr("class").split(' ');
        for (var i = 0; i < class_list.length; i++) {
            c_name = class_list[i];

            if(c_name.indexOf('bborder-#')!=-1){
                color = c_name.split('bborder-#')[1];
                if(color){
                     $(this).css({'border-bottom': '2px solid #'+ color});
                }
                break;
            }
        }
    });
}
function color_control(){
    $(".color-control").each(function () {
        class_list = $(this).attr("class").split(' ');
        for (var i = 0; i < class_list.length; i++) {
            c_name = class_list[i];
            /*背景色*/
            if(class_list[i].indexOf('bg-#')!=-1){
                pc_color = get_pc_color('bg', class_list);
                color = pc_color ? pc_color : c_name.split('-')[1];

                color = color=='#none' ? 'unset' : color;
                $(this).css({'background-color': color});
            }

            /*前景色*/
            if(class_list[i].indexOf('color-#')!=-1){
                pc_color = get_pc_color('color', class_list);
                color = pc_color ? pc_color : c_name.split('-')[1];

                color = color=='#none' ? 'inherit' : color;
                $(this).css({'color': color});
            }
        }
    });

    function get_pc_color(color_type, target) {
        pc_color = "";
        if(is_pc){
            for (var x = 0; x < target.length; x++) {
                if(target[x].indexOf(color_type + '-pc-#')!=-1){
                    pc_color = target[x].split('-')[2];
                    break;
                }
            }
        }
        return pc_color;
    }
}
function min_height_control(){
    $("[class*='min_height']").each(function () {
        class_list = $(this).attr("class").split(' ');
        var min_height = 0;
        for (var i = 0; i < class_list.length; i++) {
            c_name = class_list[i];

            if(is_pc){
                /*大螢幕最小高度*/
                if(c_name.indexOf('min_height-pc-px')!=-1){
                    min_height = c_name.split('min_height-pc-px')[1].trim();
                }
            }
            else{
                 /*小螢幕最小高度*/
                if(c_name.indexOf('min_height-px')!=-1){
                    min_height = c_name.split('min_height-px')[1].trim();
                }
            }    
        }

        $(this).css({'min-height': min_height + 'px'});
    });
}

function set_iframe_height(){
    var iframe_height = [];
    $(".articleBox  iframe").each(function () { /*全部設為0*/
        $(this).attr('height', 0);
    });
    $(".articleBox  iframe").each(function () { /*擷取各個iframe所在的articleBox高度*/
        articleBox = $(this).parent().parent().parent();
        iframe_height.push(articleBox.height()); /*紀錄高度*/
        // $(this).attr('height', articleBox.height()); /*不直接改是因為如果一塊內有多個iframe會導致越來越高*/
    });
    // console.log(iframe_height);
    for (var i = 0; i < $(".articleBox  iframe").length; i++) { /*依紀錄設定iframe高度*/
        $($(".articleBox  iframe")[i]).attr('height', iframe_height[i]);
    }
}

function set_same_height() {
    /* 半版 */
    $('.box-half').css({'height': 'auto'});
    halfs = $('.box-half');
    max_h = 0;
    for (var i = 0; i < halfs.length; i++) {
        max_h = max_h < $(halfs[i]).height() ? $(halfs[i]).height() : max_h;
    }
    $('.box-half').height(max_h);

    /*三分之一版*/
    $('.box-one_third').css({'height': 'auto'});
    halfs = $('.box-one_third');
    max_h2 = 0;
    for (var i = 0; i < halfs.length; i++) {
        max_h2 = max_h2 < $(halfs[i]).height() ? $(halfs[i]).height() : max_h2;
    }
    $('.box-one_third').height(max_h2);
}




function initial_css_after_img_loaded() {
    var imgs = document.images,
    len = imgs.length,
    counter = 0;

    [].forEach.call( imgs, function( img ) {
        var imgs = document.images,
        len = imgs.length;

        if(img.complete){
            incrementCounter();
        }
        else{
            img.addEventListener( 'load', incrementCounter, false );
        }
    } );

    function incrementCounter() {
        counter++;
        if ( counter === len ) {
            is_pc = renew_is_pc();
            initial_css_functions(); /*執行設定樣式的函式們*/
        }
    }  
}

/*執行設定樣式的函式們*/
function initial_css_functions(){
    border_color_control()
    color_control();
    min_height_control()
    set_iframe_height();
    set_same_height();
}
/*監聽螢幕大小變化*/
$( window ).resize(function() {
    is_pc = renew_is_pc();
    initial_css_functions(); /*執行設定樣式的函式們*/
});
/*頁面載入完成*/
$(document).ready(function(){
    /*等候圖片載入完成*/
    initial_css_after_img_loaded();
});

