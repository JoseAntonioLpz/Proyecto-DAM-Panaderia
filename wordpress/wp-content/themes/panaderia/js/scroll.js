$(document).ready(function(){
    function scrollToAnchor(aid) {
        var aTag = $("a[name='" + aid + "']");
        $('html,body').animate({ scrollTop: aTag.offset().top }, 'slow');
    }
    
    // .arriba es la clase del botón, top es el ancla al comienzo del html.
    $(".back-to-top").click(function() {
        scrollToAnchor('top');
    });
    
    $(window).scroll(function(e){
        var scroll = $(window).scrollTop();
        if(scroll > 720){
            $('.back-to-top').css('display', 'flex');
        }else if(scroll < 720){
            $('.back-to-top').css('display', 'none');
        }
    });

})