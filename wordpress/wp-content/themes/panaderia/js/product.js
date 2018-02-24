$(document).ready(function(){
    
    obtainProducts(1);
    
    function obtainProducts(page){
        $('#product').empty();  
        
        $.ajax({
            url: 'https://proyecto-daw-joseantoniolpz.c9users.io/tpv/product_ajax/obtainProductWP',
            type: 'post',
            dataType: 'json',
            data: {
                p: page
            }
        }).done(function(json){
            for(var i = 0; i < json.data.length; i++){
                var family = '';
                switch (json.data[i].family) {
                    case 'Pan':
                        family = 'pan';
                        break;
                    case 'Bollería':
                        family = 'bolleria';
                        break;
                    case 'Croissantería':
                        family = 'croisant';
                        break;
                    case 'Navidad':
                        family = 'navidad';
                        break;
                    case 'Otros':
                        family = 'otros';
                        break;    
                }
                /*var div = $(
                    '<div class="col-md-12">'
                    +'<div class="row">'
                    +'<div class="col-md-12">'
                    +'<div class="imgProduct" style="background-image:url(https://proyecto-daw-joseantoniolpz.c9users.io/tpv/index.php?ruta=product&accion=showImage&id=' + json.data[i].id + ');">'
                    +'<span class="nombreProduct">' + json.data[i].product + '</span>'
                    +'<span class="price">' + json.data[i].price + '</span>'
                    +'<span class="family"><img src="https://proyecto-daw-joseantoniolpz.c9users.io/wordpress/wp-content/themes/panaderia/img/panes/' + family + '.png" alt="family"/></span>'
                    +'</div>'
                    +'</div>'
                    +'<div class="col-md-12">' + json.data[i].description
                    +'<hr>'
                    +'</div>'
                    +'</div>'
                    +'</div>');*/
                    
                var div = $('<div class="card-product col-xs-12 col-sm-6 col-lg-3">'
                              +'<div class="content-card col-md-12" style="background-image:url(https://proyecto-daw-joseantoniolpz.c9users.io/tpv/product/showImage?id=' + json.data[i].id + ');">'
                                    +'<span class="nombreProduct">' + json.data[i].product + '</span>'
                                    +'<span class="price">' + json.data[i].price + '</span>'
                                    +'<span class="family"><img src="https://proyecto-daw-joseantoniolpz.c9users.io/wordpress/wp-content/themes/panaderia/img/panes/' + family + '.png" alt="family"/></span>'
                              +'</div>'
                            +'</div>');
                $('#product').append(div);   
            }
            pagination(json.paginacion);
            
        }).fail(function(){
            alert('fail');
        });    
    }
    
    function pagination(paginacion){
        var div = $('#pagination');
        div.empty();
        var previous = $('<a class="prev page-numbers margin" class="page" data-page="' + paginacion.previous + '">Previous</a>');
        div.append(previous);
        for(var i = 0; i < paginacion.range.length; i++){
            var rang = $('<a class="page-numbers margin" class="page" data-page="' + paginacion.range[i] + '">' + paginacion.range[i]  + '</a>');
            div.append(rang);
        }
        var next = $('<a class="next page-numbers margin" class="page" data-page="' + paginacion.next + '">Next</a>');
        div.append(next);
        addEvent();
    }
    
    function addEvent(){
        $('.margin').on('click', function(){
            obtainProducts($(this).data('page'));
        })
    }
});