$(document).ready(function(){
    
    verCarrito();
    
    /*$('#productBox').on('click', '.pbox' ,function(){
        $.ajax({
            url: 'index.php?accion=addCarro&ruta=carrito',
            type: 'post',
            dataType: 'json',
            data: {
                id: $(this).data('id'),
                idTicket: $('#id_ticket').val()
                //product: $(this).data('name'),
                //price: $(this).data('price'),
            }
        }).fail(
            function(){
                alert('fallo en el carro');
            }
        );    
    });*/
    
    
    function verCarrito(){
        $.ajax({
            url: 'index.php?accion=verCarro&ruta=carrito',
            type: 'post',
            dataType: 'json',
            
        }).done(function(json){
            $.each(json.data, function(i , val){
                var totalPrice = parseFloat(val.cantidad * val.item.price).toFixed(2);
                
                var tr = $('<tr class="ticket-detail">'+
                                '<td class="quantity">'+ val.cantidad +'</td>'+
                                '<td class="idproduct">'+ val.id +'</td>'+
                                '<td class="nameproduct" title="' + val.item.product + '">'+ /*desc_excerpt(*/val.item.product/*)*/ +'</td>'+
                                '<td class="pvp">'+ val.item.price +'</td>'+
                                '<td class="price">'+ totalPrice +'</td>'+
                                '<td class="fa fa-plus plus"></td>' +
                                '<td class="fa fa-minus minus"></td>' +
                                '<td class="fa fa-times rmRow"></td>' +
                           '</tr>');
                $('#tablaTicket').append(tr);
                
                //tr.find('.plus').on('click',plus);
                tr.find('.plus').on('click',function(){
                    plus($(this),val.id);
                });
                //tr.find('.minus').on('click',minus);
                tr.find('.minus').on('click',function(){
                    minus($(this),val.id);
                });
                //tr.find('.rmRow').on('click',rmRow);
                tr.find('.rmRow').on('click',function(){
                    rmRow($(this),val.id);
                });
                
                $('#id_ticket').val(json.idTicket);
            
            updateTotalPrice();
            });
            $('#id_ticket').val(json.idTicket);
        }).fail(
            function(){
                alert('fallo en el carro');
            }
        );
    }
});