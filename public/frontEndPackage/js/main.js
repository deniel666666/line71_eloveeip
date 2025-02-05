//page top
$(".page-top-btn").click(function (e) {
  e.preventDefault();
  $("html, body").animate(
    {
      scrollTop: 0,
    },
    500
  ); //500為0.5秒，為animate裡用來設定滑動到最上方(scrollTop:0)時的秒數
});

//url control
$(function () {
  if (location.pathname == "/case") {
    $("#nav-case").addClass("active");
  } else if (location.pathname.indexOf("/faq")==0) {
    $("#nav-faq").addClass("active");
  }
});

// //offcanvas control
$(function () {
  "use strict";
  $('[data-toggle="offcanvas"]').on("click", function () {
    $(".offcanvas-collapse").toggleClass("open");
  });
});
