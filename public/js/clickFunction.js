$(".askBtn").click(function(){
});
 $(".accordionBtn").click(function(){
});             
//印刷清單↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
$(document).ready(function(){
    $(".printListBtn").click(function(){
            var bodyScrollHeight = $(document).height();
            $('html, body').animate({ scrollTop: bodyScrollHeight }, 300);
    });
});