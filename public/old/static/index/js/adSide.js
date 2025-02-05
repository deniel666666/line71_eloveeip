 $(".closeAdSide").on("click", function () {
     if ($(".adSidebg").hasClass('d-none')) {
         $(".adSidebg").removeClass('d-none');

     } else {
         $(".adSidebg").addClass('d-none');

     }

     $.ajax({
         url: "/index/ajax/closeAdSide.html",
         type: 'get',
         datatype: 'json',
         error: function (xhr) {},
         success: function (response) {}

     });
 });

