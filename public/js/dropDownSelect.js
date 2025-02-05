    // 下拉式選單

$(document).ready(function(){
    $(".js-select").each(function() {
        var classes = $(this).attr("class"),
            id      = $(this).attr("id"),
            name    = $(this).attr("name"),
            placeholder = $(this).attr("placeholder");
        var template =  '<div class="' + classes + '">';

        template += '<span class="select-trigger stepSelectNum">' + placeholder + '</span>';
        template += '<div class="options selectContent">';
        $(this).find("option").each(function() {
            template += '<span class="option ' + $(this).attr("class") + '" data-value="' + $(this).attr("value") + '">' + $(this).html() + '</span>';
        });
        template += '</div></div>';
      
        $(this).wrap('<div class="select-wrap"></div>');
        $(this).hide();
        $(this).after(template);
    });

    selectTrigger();
});

function selectTrigger() {
    $(".select-trigger").on("click", function() {
        $(".select-trigger").parents(".select").removeClass("opened");//點擊其他隱藏
        $(this).parents(".select").toggleClass("opened");
        $(this).parents(".select").find(".options").css("z-index","9999");//順序置上

        event.stopPropagation();
    });
    $(".option").on("click", function() {
        var select  = $(this).parents(".select-wrap"),
        val     = $(this).attr("data-val");
        select.find("select").val($(this).data("value"));
        select.find("option").removeAttr("selected");
        select.find('option[value='+val+']').attr("selected", "selected");
        $(this).parents(".select").removeClass("opened");
        $(this).css("z-index","0");//順序置下
        $(this).parents(".select").addClass("selected");
        $(this).parents(".select").find(".select-trigger").text($(this).text());
    });
    $('html').on('click',function() {
        $(".select").removeClass("opened");
    });
    
}

