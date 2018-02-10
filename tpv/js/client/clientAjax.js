$(document).ready(function(){
    
    //apertura y cierre de la ventana modal
    $("#point_ticket").click(function() {
        $(".blur").css('filter', 'blur(10px)');
        //$('#form_register_client').remove();
        $('.close').siblings().remove();
        $("#modalEdit").css('display', 'block');
        
        
        $.ajax(
            // Hago la llamada
            {
                url: 'index.php?ruta=client_ajax&accion=get_clients_ajax',
                type: 'get',
                dataType: 'json'
            }
        ).done(
            // Recibo la respuesta.
            function(json){
                var clients = json.clients;
                var selectClient = 
                $('<div id="form_register_client">' +
                  '<form id="search-client">'+
                      '<input id="searchClientInput" type="search" placeholder="Search" name="search_client">'+
                      '<button type="submit" id="btSearchClient"><i class="fa fa-search"></i></button>'+
                  '</form>'+
                  '<ul id="resultSearch"></ul>'+
                  '<h3>Register ticket</h3>' +
                  '<form id="register_ticket_form">' +
                    '<select id="select_client_id" name="clientID"></select>' +
                    '<button id="button_register_ticket" type="submit">Register ticket</button>' +
                  '</form>' +
                  '</div>');
                
                for(var i = 0; i < clients.length; i++){
                    var option = $('<option value="' + clients[i].id + '">' + clients[i].name +'</option>');
                    selectClient.find('#select_client_id').append(option);
                }
                //$('.modal-content').append(selectClient);
                
                $('.modal-content').find('.close').after(selectClient);
                
                //manejador de eventos para apuntar tickets
                $('#register_ticket_form').on('submit',registerTicket);
                
                //manejador de eventos para buscar cliente
                $('#search-client').on('submit',searchClient);
            }
        ).fail(
            // No recibo la respuesta y hay un error
            function(){
                alert('Ha fallado la lista de clientes');
            }
        ).always(
            // Se ejecuta siempre
            function(){
                
            }
        );
    });
    
    function searchClient(e){
        e.preventDefault();
        $('#resultSearch').children().remove();
        var word = $('#searchClientInput').val();
        var res = false;
        if(word !== ''){
            var options = $('#select_client_id').children();
            $.each(options,function(){
                if($(this).text().toLowerCase().search(word.toLowerCase())>=0){
                    var li = $('<li><span>'+ $(this).text() +'</span><button class="btSelectSearch">Select</button></li>');
                    $('#resultSearch').append(li);
                    li.find('.btSelectSearch').on('click',selectClient);
                    res = true;
                }
            });
            if(!res){
                $('#resultSearch').append($('<span>No Results</span>'));
            }
        }
    }
    
    function selectClient(){
        var nameClient = $(this).prev('span').text();
        var options = $('#select_client_id').children();
        options.removeAttr('selected');
        $.each(options,function(){
            if($(this).text() === nameClient){
                $(this).attr('selected','selected');
            }
        });
    }
    
    // Cuando hace click en la X oculta.
    $(".close").click(function() {
        $(".blur").css('filter', 'blur(0px)')
        $("#modalEdit").css('display', 'none');
        $('.close').siblings().remove();
    });
    
    
    //registrar ticket
    function registerTicket(e){
        e.preventDefault();
        var nameClient = $('#select_client_id option:selected').text();
        var idClient = $('#select_client_id').val();
        $.ajax(
            // Hago la llamada
            {
                url: 'index.php?ruta=ticket_ajax&accion=register_ticket&idTicket='+$('#id_ticket').val() +'&idClient='+idClient,
                type: 'get',
                dataType: 'json'
            }
        ).done(
            // Recibo la respuesta.
            function(json){
                var result = json.res;
                if(result.res === 1){
                    $(".blur").css('filter', 'blur(0px)')
                    $("#modalEdit").css('display', 'none');
                    $('.cuenta .divHeader p').text('TPV: Ticket de ' + nameClient);
                }
            }
        ).fail(
            // No recibo la respuesta y hay un error
            function(){
                alert('Ha fallado la lista de clientes');
            }
        ).always(
            // Se ejecuta siempre
            function(){
                
            }
        );
    }
    
});