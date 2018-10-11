jQuery(document).ready(function() {

    var $ = jQuery;

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