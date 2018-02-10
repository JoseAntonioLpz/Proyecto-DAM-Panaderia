$(document).ready(function() {

    
    
    // Paginacion productos
    var page = 0;
    /**
    setTimeout(
        function(){
            getAll(0, '');
        }, 2000);
    //*/
    getAll(0, '', 0);

    function getAll(idfamily, text, page) {
        
        if (page < 1){
            $('#productBox').empty();
        }

        $.ajax({
            url: 'index.php',
            type: 'get',
            dataType: 'json',
            data: {
                ruta: 'product_ajax',
                accion: 'getAllProducts',
                idfamily: idfamily,
                text: text,
                page: page
            }
        }).done(
            function(json) {
                console.log(json.list);
                var list = json.list;
                if (list.length < 1) {
                    $('#productBox').append("<h2>No se han encontrado productos.</h2>");
                }
                else {
                    $("#loadmore").remove();
                    for (var i in list) {
                        var product = list[i];
                        createProduct(product);
                    }
                    var loadmore = $('<div id="loadmore" class="bold">Load more</div>');
                    $('#productBox').append(loadmore);
                    $("#loadmore").click(function() {
                        page = page + 9;
                        getAll(0, null, page);
                    });
                }
            }
        ).fail(
            function(json) {
                console.log(json.list);
                console.log("Hubo un error.");
            }
        );
    }
    
    function createProduct(product) {
        var id = product.id;
        var idfamily = product.idfamily;
        var name = product.product;
        var price = product.price;
        var description = product.description;

        var div = $('<div class="pbox" data-id="' + id + '" data-name="' + name + '" data-price="' + price + '">' +
            '<div class="pimg" style="background-image: url(?ruta=product&accion=showImage&id=' + id + ');">' +
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
        
        //dibujo formulario para introducir cantidad
        var inputCant = $('<input type="number" name="cant" id="cant" placeholder="Quantity">');
        var btCant = $('<button id="writeCant">OK</button>');
        var btClose = $('.close');
        btClose.siblings().remove();
        btClose.before(inputCant);
        btClose.before(btCant);
        
        
        btCant.on('click',function(){//dibujo la linea con sus datos en la tabla de factura
            drawQuantity(product);
            $(".blur").css('filter', 'blur(0px)')
            $("#modalEdit").css('display', 'none');
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
            var totalPrice = quantity*pvp;
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
    
    function desc_excerpt(description){
        console.log(description);
        var newDesc = $.trim(description).substring(0, 12);
        if (description.length > 12){
            newDesc += "...";
        }
        return newDesc;
    }
    
    //poner cantidad de producto que introduces en ventana modal
    function drawQuantity(product){
        var quantity = parseInt($('#cant').val());
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
            var totalPrice = quantity*pvp;
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
            url: 'index.php?ruta=family',
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
            getAll(id, '', page);
        });
    }
    
    // First child porque es mostrar todos.
    $(".changeCat:first-child").click(function(){
        $("#searchProductBtn").closest(".searchProduct").find("input[name='search']").val('');
        page = 0;
        getAll(0, '', page);
    });
    
    
    // --------------------------------Buscar producto
    $("#searchProductBtn").click(function(){
       var search = $(this).closest(".searchProduct").find("input[name='search']").val();
       page = 0;
       getAll(0, search, page);
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



function addCarrito(idProduct){
    $.ajax({
        url: 'index.php?accion=addCarro&ruta=carrito',
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
        url: 'index.php?accion=addCarro&ruta=carrito',
        type: 'post',
        dataType: 'json',
        data: {
            id: idProduct,
            cantidad: $('#cant').val(),
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

function subCarrito(idProduct){
    $.ajax({
        url: 'index.php?accion=subCarro&ruta=carrito',
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

function removeCarrito(idProduct){
    $.ajax({
        url: 'index.php?accion=removeCarro&ruta=carrito',
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