 $(".closeAdSide").on("click", function () {
     if ($(".adSidebg").hasClass('d-none')) {
         $(".adSidebg").removeClass('d-none');

     } else {
         $(".adSidebg").addClass('d-none');

     }

     $.ajax({
         url: "/Ajax/closeAdSide",
         type: 'get',
         /* headers: {
            'X-CSRF-Token': csrf_token 
         }, */
         datatype: 'json',
         error: function (xhr) {},
         success: function (response) {}

     });
 });

