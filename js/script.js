$(function() {

    $(".hamburger").on("click", function() {
        $(this).toggleClass("btn-mobile");
        $(".menuMobile-content").slideToggle();
    });


    //Animação 
    var $target = $('.anime'),
        animationClass = 'anime-start',
        offset = $(window).height() * 3 / 4;

    function animeScroll2() {
        var documentTop = $(document).scrollTop();

        $target.each(function() {
            var itemTop = $(this).offset().top;

            if (documentTop > itemTop - offset) {
                $(this).addClass(animationClass);
            }
        });
    }

    animeScroll2();

    $(document).scroll(function() {
        animeScroll2();
    });


    $("#id_tel").mask("(99) 99999-9999");

});