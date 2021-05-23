$(function() {

    $(".hamburger").on("click", function() {
        $(this).toggleClass("btn-mobile");
        $(".menuMobile-content").slideToggle();
    });

});