jQuery(document).ready(function() {

    var $ = jQuery;
    if (!sessionStorage.isVisited) {
        sessionStorage.isVisited = 'true';
        $('#preloader').delay(5000).fadeOut('slow');
        $('body').delay(5000).css({'overflow':'visible'});
        setTimeout(function(){
            $('.home .country-selector').css("opacity", "1");
            $('.home nav, .home #logo').css("opacity", "1");
            $('.home header, .home #header-outer').css("background", "#fff");
        }, 5000);
    }else{
        $('#preloader').fadeOut('slow');
        $('body').css({'overflow':'visible'});
        setTimeout(function(){
            $('.home .country-selector').css("opacity", "1");
            $('.home nav, .home #logo').css("opacity", "1");
            $('.home header, .home #header-outer').css("background", "#fff");
        }, 1);
    }

    $('.divider-1 .divider-wrap:first-child > div').css('height', '20px');
    $('.divider-2 .divider-wrap:first-child > div').css('height', '20px');
    $('.divider-3 .divider-wrap:first-child > div').css('height', '20px');

    $('.divider-1 .wpb_wrapper').hover(function(){
        $(this).find('.divider-wrap:first-child > div').css("height", "300px");
    }, function(){
        $(this).find('.divider-wrap:first-child > div').css("height", "20px");
    });

    $('.divider-2 .wpb_wrapper').hover(function(){
        $(this).find('.divider-wrap:first-child > div').css("height", "300px");
    }, function(){
        $(this).find('.divider-wrap:first-child > div').css("height", "20px");
    });

    $('.divider-3 .wpb_wrapper').hover(function(){
        $(this).find('.divider-wrap:first-child > div').css("height", "300px");
    }, function(){
        $(this).find('.divider-wrap:first-child > div').css("height", "20px");
    });

    $('.bloc-expand').css('display', 'none');
    $('.accordion .nectar_icon').click(function (e) { 
        e.preventDefault();
        $(this).parent().parent().find('.bloc-expand').toggleClass('expand');
    });
});
