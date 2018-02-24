function incrementNumber(val , field){
    var campo = field,
        value = parseInt(val);
    $({percentage: 0}).stop(true).animate({percentage: value}, {
        duration : 500,
        //easing: "easeOutExpo",
        step: function () {
            var percentageVal = Math.round(this.percentage);
            
            campo.text(percentageVal);
        }
    }).promise().done(function () {
        campo.text(value);
    });
}

$(document).ready(function(){
    
    $(window).scroll(function(event){
        var scroll = $(window).scrollTop();
        if(scroll > 2450){
            $(this).off(event);
            $.ajax({
                url: 'https://proyecto-daw-joseantoniolpz.c9users.io/tpv/wp',
                type: 'post',
                dataType: 'json',
            }).done(function(json){
                incrementNumber(json.data.member, $('#member'));
                incrementNumber(json.data.client, $('#client'));
                incrementNumber(json.data.product, $('#producto'));
            }).fail(function(){
                alert('fail');
            });
        }
    });
});