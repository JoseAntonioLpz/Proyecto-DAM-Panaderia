$(document).ready(function () {
    
    //createTicket();
    
    //$('#nuevoTicket').on('click' , createTicket);
    
    $('#nuevoTicket').on('click',function(){
        /*if($('#tablaTicket tr').length > 1){*/
            myConfirm();
        /*}*/
    });
    
});

function createTicket(){
    /*if($('#tablaTicket tr').length > 1){
        if(!confirm('¿Quieres borrar el ticket actual?')){
            return;
        }
    }*/
    var child = $('<tbody><tr class="medium"><td>Cant.</td><td>Cod.</td><td>Descripcion</td><td>PVP/U</td><td>Subtotal</td><td>Accion</td></tr></tbody>');
    $('#tablaTicket').empty();
    $('#tablaTicket').append(child);
    
    $.ajax(
        {
            url: 'ticket_ajax/addTicket',
            type: 'post',
            dataType: 'json',
            data: {
                //idmember : $('#id_member').val(),
                //idclient : 1, //Cambiar
            }
        }
    ).done(
        function(json){
            //alert('Id del ticket:' + json.data['id'])
            //$('#id_ticket').val(json.data['id']);
            $('#id_ticket').val(json.idTicket);
            alert('creado ' + json.idTicket);
            
            //quitar el nombre del cliente del anterior ticket
            var tClient = $('<p class="big thin blue"><i class="fa fa-shopping-cart" aria-hidden="true"></i>TPV</p>');
            $('.cuenta .divHeader').html(tClient);
        }
    ).fail(
        function(){
            alert('Fallo al insertar');
        }
    ).always(function(){
        $.ajax({
            url: 'carrito/reiniciarCarro',
            type: 'post',
            dataType: 'json',
            data:{
                //id: $('#id_ticket').val()
            }
            
        });/*.done(function(json){
            $('#id_ticket').val(json.idTicket);
        });*/
                
    });
}
   
   
function myConfirm(){
    $(".blur").css('filter', 'blur(10px)');
    $("#modalEdit").css('display', 'block');
    $('.modal-content').find('.close').siblings().remove();
    
    /*darle estilo*/
    $('.modal-content').addClass('modal-apuntar');
    $('.close').addClass('apuntar');
    
    var message = $('<h3 class="are-you-sure">¿Are you sure to remove actual ticket?</h3>');
    var bts = $('<div class="actions">'+
                        '<button class="bt-action confirm btnDelete">Remove</button>'+
                        '<button class="bt-action remove close btnEdit">Cancel</i></button>'+
                '</div>');
    $('.modal-content').append(message);
    $('.modal-content').append(bts);
    
    $('.confirm').on('click',function(){
        createTicket();
        cerrarVentana();
    });
    
    // Cuando hace click en cancel oculta.
    $(".bt-action.close").click(cerrarVentana);
}

function cerrarVentana(){
    $(".blur").css('filter', 'blur(0px)')
    $("#modalEdit").css('display', 'none');
    $('.modal-content').find('.close').siblings().remove();
    
    $('.modal-content').removeClass('modal-apuntar');
    $('.close').removeClass('apuntar');
}