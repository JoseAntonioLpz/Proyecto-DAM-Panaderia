$(document).ready(function() {

    
    
    // Paginacion productos
    var page = 0;
    // Paginacion familias
    var cat = 0;
    // Paginacion busqueda
    var searching = '';
    // Elementos por página
    var limit = 16;
    
    
    var loading = '<div class="loadbox">'+
                        '<div class="loading"></div>'+
                        '<div class="loading"></div>'+
                        '<div class="loading"></div>'+
                    '</div>';
    /**
    setTimeout(
        function(){
            getAll(0, '');
        }, 2000);
    //*/
    getAll(cat, searching, page, limit);

    function getAll(idfamily, text, page, limit) {
        
        $('#productBox').append(loading);
        
        if (page < 1){
            $('#productBox').empty();
        }

        $.ajax({
            url: 'product_ajax/getAllProducts',
            type: 'get',
            dataType: 'json',
            data: {
                idfamily: idfamily,
                text: text,
                page: page,
                limit: limit
            }
        }).done(
            function(json) {
                console.log(json.list);
                var list = json.list;
                
                $(".loadbox").remove();
                
                if (list.length < 1) {
                    $('#productBox').append("<h3>Products not found</h3>");
                }
                else {
                    $(".pbox.ghost").remove();
                    $("#loadmore").remove();
                    var counter = 0;
                    for (var i in list) {
                        var product = list[i];
                        createProduct(product);
                    }
                    var previous = $(".pbox").length;
                    console.log(previous);
                    var multipleFound = false;
                    var nearest = previous;
                    while(!multipleFound){
                        var n = nearest % 4;
                        if (n == 0){
                            multipleFound = true;
                        }else{
                            nearest++;
                        }
                    }
                    
                    var loadmore = $('<div id="loadmore" class="bold">Load more</div>');
                    $('#productBox').append(loadmore);
                    $("#loadmore").click(function() {
                        page = page + 9;
                        getAll(cat, searching, page, limit);
                    });

                    var nGhosts = nearest - previous;
                    for (var i = 0; i < nGhosts; i++){
                        createGhost();
                    }
                    
                }
            }
        ).fail(
            function(json) {
                console.log(json.list);
                console.log("Hubo un error.");
            }
        );
    }
    
    function createGhost(){
        $('#loadmore').remove();
        var div = $('<div class="pbox ghost">' +
            '</div>');
        $('#productBox').append(div);
    }
    
    function createProduct(product) {
        var id = product.id;
        var idfamily = product.idfamily;
        var name = product.product;
        var price = product.price;
        var description = product.description;

        var div = $('<div class="pbox" data-id="' + id + '" data-name="' + name + '" data-price="' + price + '">' +
            '<div class="pimg" style="background-image: url(product/showImage?id=' + id + ');">' +
            '<div title="' + description + '">' +
            '<h3>' + name + '</h3>' +
            '</div>' +
            '</div>' +
            '</div>');
        $('#productBox').append(div);
        //div.on('click',drawDataTable);
        //si mantienes pulsado un pbox más de 0.8s se abre modal pidiendo cantidad,
        //si no, se incrementa la cantidad en 1
        div.on('mousedown',mouseDOWN);
        div.on('mouseup',mouseUP);
    }
    
    $(".close").click(function() {//para cerrar la ventana modal
        $(".blur").css('filter', 'blur(0px)')
        $("#modalEdit").css('display', 'none');
    });
    
    // Cierra el modal cuando click fuera
    $("#modalEdit").click(function(e) {
        if (e.target.id == "modalEdit"){
            $(".blur").css('filter', 'blur(0px)')
            $("#modalEdit").css('display', 'none');
        }
    });
    
    var miInterval = null;
    function mouseDOWN(){//con esta función cuento el tiempo que el usuario pulsa el producto
        var product = $(this);
        miInterval = setInterval(function(){
            openWindow(product);
        },800);
    }
    
    function mouseUP(){
        clearInterval(miInterval);
        drawDataTable($(this));//si se ha pulsado rapido se dibuja la linea de datos con  cantidad 1
    }
    
    function openWindow(product){
        clearInterval(miInterval);//limpio contador de tiempo
        //abro ventana
        $(".blur").css('filter', 'blur(10px)');
        $("#modalEdit").css('display', 'block');
        
        $('.modal-content').addClass('modal-apuntar');
        $('.close').addClass('apuntar');
        
        //dibujo formulario para introducir cantidad
        /*var inputCant = $('<input type="number" name="cant" id="cant" placeholder="Quantity" min="1">');
        var btCant = $('<button id="writeCant">OK</button>');
        var btClose = $('.close');
        btClose.siblings().remove();
        btClose.before(inputCant);
        btClose.before(btCant);*/
        
        var inputCant = $('<div class="container-cant"><input type="number" name="cant" id="cant" placeholder="Quantity" min="1"><button class="writeCant">OK</button></div>');
        //var btCant = $('');
        var btClose = $('.close');
        btClose.siblings().remove();
        btClose.before(inputCant);
        //btClose.before(btCant);
        
        
        /*btCant.on('click',function(){//dibujo la linea con sus datos en la tabla de factura
            drawQuantity($(this),product);
            $(".blur").css('filter', 'blur(0px)')
            $("#modalEdit").css('display', 'none');
            
            $('.modal-content').removeClass('modal-apuntar');
            $('.close').removeClass('apuntar');
        });*///modificar cantidad en la ventana modal
        
        inputCant.find('.writeCant').on('click',function(){//dibujo la linea con sus datos en la tabla de factura
            drawQuantity($(this),product);
            $(".blur").css('filter', 'blur(0px)')
            $("#modalEdit").css('display', 'none');
            
            $('.modal-content').removeClass('modal-apuntar');
            $('.close').removeClass('apuntar');
        });//modificar cantidad en la ventana modal
    }
    
    
    function drawDataTable(product){
        var id = product.data('id');
        var name = product.data('name');
        var pvp = product.data('price');
        var quantity = 1;
        
        var repeat = false;
        //comprobar si el producto ya está en la lista
        var idProducts = $('.ticket-detail').find('.idproduct');
        $.each(idProducts,function(){
            if(id == $(this).text()){//si está en la lista modifica la fila y sale del bucle
                quantity = parseInt($(this).siblings('.quantity').text());
                quantity++;
                $(this).parent().find('.quantity').text(quantity);
                $(this).parent().find('.price').text(parseFloat(quantity * parseFloat($(this).parent().find('.pvp').text())).toFixed(2));
                repeat = true;
                return false;
            }else{
                quantity = 1;
            }
        });

        if(!repeat){//si no está el producto en la lista crea su correspondiente fila
            var totalPrice = parseFloat(quantity*pvp).toFixed(2);
            var tr = $('<tr class="ticket-detail">'+
                            '<td class="quantity">'+ quantity +'</td>'+
                            '<td class="idproduct">'+ id +'</td>'+
                            '<td class="nameproduct" title="' + name + '">'+ desc_excerpt(name) +'</td>'+
                            '<td class="pvp">'+ pvp +'</td>'+
                            '<td class="price">'+ totalPrice +'</td>'+
                            '<td class="fa fa-plus plus"></td>' +
                            '<td class="fa fa-minus minus"></td>' +
                            '<td class="fa fa-times rmRow"></td>' +
                       '</tr>');
            $('#tablaTicket').append(tr);
            
            //tr.find('.plus').on('click',plus);
            tr.find('.plus').on('click',function(){
                plus($(this),id);
            });
            //tr.find('.minus').on('click',minus);
            tr.find('.minus').on('click',function(){
                minus($(this),id);
            });
            //tr.find('.rmRow').on('click',rmRow);
            tr.find('.rmRow').on('click',function(){
                rmRow($(this),id);
            });
        }
        addCarrito(id);//guardamos en el carrito
        updateTotalPrice();//actualizar precio total del pedido
    }
    
    //poner cantidad de producto que introduces en ventana modal
    function drawQuantity(bt,product){
        var quantity = parseInt(bt.siblings('#cant').val());
        var idProducts = $('.ticket-detail').find('.idproduct');
        var id = product.data('id');
        var name = product.data('name');
        var pvp = product.data('price');
        var repeat = false;
        $.each(idProducts,function(){
            if(id == $(this).text()){
                $(this).parent().find('.quantity').text(quantity);
                $(this).parent().find('.price').text(parseFloat(quantity * parseFloat($(this).parent().find('.pvp').text())).toFixed(2));
                repeat = true;
                return false;//para salir del ciclo
            }
        });
        
        if(!repeat){
            var totalPrice = parseFloat(quantity*pvp).toFixed(2);
            var tr = $('<tr class="ticket-detail">'+
                            '<td class="quantity">'+ quantity +'</td>'+
                            '<td class="idproduct">'+ id +'</td>'+
                            '<td class="nameproduct" title="' + name + '">'+ desc_excerpt(name) +'</td>'+
                            '<td class="pvp">'+ pvp +'</td>'+
                            '<td class="price">'+ totalPrice +'</td>'+
                            '<td class="fa fa-plus plus"></td>' +
                            '<td class="fa fa-minus minus"></td>' +
                            '<td class="fa fa-times rmRow"></td>' +
                       '</tr>');
            $('#tablaTicket').append(tr);
            
            //tr.find('.plus').on('click',plus);
            tr.find('.plus').on('click',function(){
                plus($(this),id);
            });
            //tr.find('.minus').on('click',minus);
            tr.find('.minus').on('click',function(){
                minus($(this),id);
            });
            //tr.find('.rmRow').on('click',rmRow);
            tr.find('.rmRow').on('click',function(){
                rmRow($(this),id);
            });
        }
        addCarrito2(id);
        updateTotalPrice();
    }
    
    //incrementa cantidad en 1 clickando en simbolo +
    
    //decrementa cantidad en 1 clickando en simbolo -
    
    /***************************** FAMILY ************************************/
    var familias = $('#familias');
    $.ajax(
        // Hago la llamada
        {
            url: 'family',
            type: 'get',
            dataType: 'json'
        }
    ).done(
        // Recibo la respuesta.
        function(json) {
            var data = json.data;
            for (var i = 0; i < data.length; i++) {
                var li = $('<div class="changeCat bold" data-id="' + data[i].id + '">' + data[i].family + '</div>');
                add_event(data[i].id, li);
                familias.append(li);
            }
        }
    ).fail(
        // No recibo la respuesta y hay un error
        function() {
            alert('Esto ha fallado');
        }
    ).always(
        // Se ejecuta siempre
        function() {

        }
    );

    function add_event(id, campo){
        campo.on('click', function(e){
            cat = id;
            getAll(cat, '', page, limit);
        });
    }
    
    // First child porque es mostrar todos.
    $(".changeCat:first-child").click(function(){
        $("#searchProductBtn").closest(".searchProduct").find("input[name='search']").val('');
        page = 0;
        cat = 0;
        getAll(cat, '', page, limit);
    });
    
    
    // --------------------------------Buscar producto
    $("#searchProductBtn").click(function(){
       var search = $(this).closest(".searchProduct").find("input[name='search']").val();
       page = 0;
       searching = search;
       getAll(0, searching, page, limit);
    });
    
    
});


function plus(mas,idProduct){
    //$(this).siblings('.quantity').text(parseInt($(this).siblings('.quantity').text()) + 1);
    //$(this).siblings('.price').text(parseFloat(($(this).siblings('.pvp').text()) * parseInt($(this).siblings('.quantity').text())).toFixed(2));
    mas.siblings('.quantity').text(parseInt(mas.siblings('.quantity').text()) + 1);
    mas.siblings('.price').text(parseFloat(parseFloat(mas.siblings('.pvp').text()) * parseInt(mas.siblings('.quantity').text())).toFixed(2));
    addCarrito(idProduct);
    updateTotalPrice();
}

function minus(menos,idProduct){
    if(parseInt(menos.siblings('.quantity').text()) > 1 ){
        //$(this).siblings('.quantity').text(parseInt($(this).siblings('.quantity').text()) - 1);   
        //$(this).siblings('.price').text(parseFloat(($(this).siblings('.pvp').text()) * parseInt($(this).siblings('.quantity').text())).toFixed(2));
        menos.siblings('.quantity').text(parseInt(menos.siblings('.quantity').text()) - 1);   
        menos.siblings('.price').text(parseFloat(parseFloat(menos.siblings('.pvp').text()) * parseInt(menos.siblings('.quantity').text())).toFixed(2));
    }
    subCarrito(idProduct);
    updateTotalPrice();
}

//elimina linea de la tabla clickando simbolo x
function rmRow(rm,idProduct){
    //$(this).parent().remove();
    rm.parent().remove();
    removeCarrito(idProduct);
    updateTotalPrice();
}

//actualiza el precio total del ticket
function updateTotalPrice(){
    var total = 0;
    $.each($('.price'),function(){
        total += parseFloat($(this).text());
    });
    $('#totalResult').text(parseFloat(total).toFixed(2) + '€');
}


function desc_excerpt(description){
    console.log(description);
    var newDesc = $.trim(description).substring(0, 12);
    if (description.length > 12){
        newDesc += "...";
    }
    return newDesc;
}



function addCarrito(idProduct){
    $.ajax({
        url: 'carrito/addCarro',
        type: 'post',
        dataType: 'json',
        data: {
            id: idProduct,
            idTicket: $('#id_ticket').val()
        }
    }).done(function(json){
        //$('#id_ticket').val(json.idTicket); Esto reiniciaba el ticket, pero ya esta arreglado
    }).fail(
        function(){
            alert('fallo en el carro');
        }
    );
}


function addCarrito2(idProduct){
    $.ajax({
        url: 'carrito/addCarro',
        type: 'post',
        dataType: 'json',
        data: {
            id: idProduct,
            cantidad: $('#cant').val(),
            idTicket: $('#id_ticket').val()
        }
    }).done(function(json){
        $('#id_ticket').val(json.idTicket);
    }).fail(
        function(){
            alert('fallo en el carro');
        }
    );
}

function subCarrito(idProduct){
    $.ajax({
        url: 'carrito/subCarro',
        type: 'post',
        dataType: 'json',
        data: {
            id: idProduct,
            idTicket: $('#id_ticket').val()
        }
    }).done(function(json){
        $('#id_ticket').val(json.idTicket);
    }).fail(
        function(){
            alert('fallo en el carro');
        }
    );
}

function removeCarrito(idProduct){
    $.ajax({
        url: 'carrito/removeCarro',
        type: 'post',
        dataType: 'json',
        data: {
            id: idProduct,
            idTicket: $('#id_ticket').val()
        }
    }).fail(
        function(){
            alert('fallo en el carro');
        }
    );
}