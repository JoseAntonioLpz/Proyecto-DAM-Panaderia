$(document).ready(function () {
    
    //createTicket();
    
    $('#nuevoTicket').on('click' , createTicket);
    
    function createTicket(){
        if($('#tablaTicket tr').length > 1){
            if(!confirm('¿Quieres borrar el ticket actual?')){
                return;
            }
        }
        var child = $('<tr class="redColor"><td>Cant.</td><td>Cod.</td><td>Descripcion</td><td>PVP/U</td><td>Subtotal</td><td>Accion</td></tr>');
        $('#tablaTicket').empty();
        $('#tablaTicket').append(child);
        
        $.ajax(
            {
                url: 'index.php?accion=addTicket&ruta=ticket_ajax',
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
                $('#id_ticket').val(json.data['id']);
            }
        ).fail(
            function(){
                alert('Fallo al insertar');
            }
        ).always(function(){
            $.ajax({
                url: 'index.php?accion=reiniciarCarro&ruta=carrito',
                type: 'post',
                dataType: 'json',
            });
        });
    }
});