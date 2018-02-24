$(document).ready(function(){
     
     var nav = $('header .navigation');
     var logo = $('.navigation .logo');
     
     $(document).scroll(function(){
        if($(document).scrollTop() > 80 && $(document).width() > 991){
            nav.animate(nav.addClass('navScroll'));
            logo.css('display','none');
            $('.logoScroll').css('display','block');
            nav.css('overflow','initial');
            
            $('#relleno').css('display','block');
        }else{
            nav.removeClass('navScroll');
            logo.css('display','block');
            $('.logoScroll').css('display','none');
            
            if($(document).width() > 991){
                $('#relleno').css('display','none');
            }
        }
    });
    
    $('.btNav').on('click',desplegar);
    
    function desplegar(){
        //$('.navigation').find('.navigation-list').css('display','flex');
        $('.navigation').find('.navigation-list').addClass('mostrar');
        $(this).off();
        $(this).on('click',recoger);
    }
    
    function recoger(){
        //$('.navigation').find('.navigation-list').css('display','none');
        $('.navigation').find('.navigation-list').removeClass('mostrar');
        $(this).off();
        $(this).on('click',desplegar);
    }
    
});