$(document).ready(function(){
    
    //apertura y cierre de la ventana modal
    $("#point_ticket").click(function() {
        $(".blur").css('filter', 'blur(10px)');
        //$('#form_register_client').remove();
        $('.close').siblings().remove();
        $("#modalEdit").css('display', 'block');
        
        /*darle estilo*/
        $('.modal-content').addClass('modal-apuntar');
        $('.close').addClass('apuntar');
        
        
        $.ajax(
            // Hago la llamada
            {
                url: 'client_ajax/get_clients_ajax',
                type: 'get',
                dataType: 'json'
            }
        ).done(
            // Recibo la respuesta.
            function(json){
                var clients = json.clients;
                /*var selectClient = 
                $('<div id="form_register_client">' +
                  '<form id="search-client"  class="search-client-form">'+
                      '<input class="input-search-client" id="searchClientInput" type="search" placeholder="Search" name="search_client">'+
                      '<button class="bt-search-client" type="submit" id="btSearchClient"><i class="fa fa-search"></i></button>'+
                  '</form>'+
                  '<div id="resultSearch"></div>'+
                  '<h3>Register ticket</h3>' +
                  '<form id="register_ticket_form" class="register_ticket_form">' +
                    '<select id="select_client_id" name="clientID"></select>' +
                    '<button id="button_register_ticket" type="submit">Register ticket</button>' +
                  '</form>' +
                  '</div>');*/
                  
                var selectClient = 
                $('<div class="div_form_register_client">' +
                  '<form class="search-client-form">'+
                      '<input class="input-search-client" type="search" placeholder="Search" name="search_client">'+
                      '<button class="bt-search-client" type="submit"><i class="fa fa-search"></i></button>'+
                  '</form>'+
                  '<div class="resultSearch"></div>'+
                  '<h3>Register ticket</h3>' +
                  '<form class="register_ticket_form">' +
                    '<select class="select_client_id" name="clientID"></select>' +
                    '<button class="button_register_ticket" type="submit">Register ticket</button>' +
                  '</form>' +
                  '</div>');
                
                for(var i = 0; i < clients.length; i++){
                    var option = $('<option value="' + clients[i].id + '">' + clients[i].name +'</option>');
                    selectClient.find('.select_client_id').append(option);
                }
                //$('.modal-content').append(selectClient);
                
                $('.modal-content').find('.close').after(selectClient);
                
                //manejador de eventos para apuntar tickets
                //$('#register_ticket_form').on('submit',registerTicket);
                $('.register_ticket_form').on('submit',registerTicket);
                
                //manejador de eventos para buscar cliente
                //$('#search-client').on('submit',searchClient);
                $('.search-client-form').on('submit',searchClient);
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
    
    
    
    // Cuando hace click en la X oculta.
    $(".close").click(function() {
        $(".blur").css('filter', 'blur(0px)')
        $("#modalEdit").css('display', 'none');
        
        $('.modal-content').removeClass('modal-apuntar');
        $('.close').removeClass('apuntar');
        
        $(this).siblings().remove();
    });
    
    
    //registrar ticket
});

function registerTicket(e){
        e.preventDefault();
        var nameClient = $(this).find('.select_client_id option:selected').text();
        var idClient = $('.select_client_id').val();
        $.ajax(
            // Hago la llamada
            {
                url: 'ticket_ajax/register_ticket&idTicket='+$('#id_ticket').val() +'&idClient='+idClient,
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
                    
                    $('.modal-content').removeClass('modal-apuntar');
                    $('.close').removeClass('apuntar');
                    
                    var tClient = $('<p class="big thin blue"><i class="fa fa-shopping-cart" aria-hidden="true"></i>TPV: Ticket de ' + nameClient +'</p>');
                    $('.cuenta .divHeader').html(tClient);
                    
                    $('.close').siblings().remove();
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
    
    function searchClient(e){
        e.preventDefault();
        $('.resultSearch').children().remove();
        //var word = $('.input-search-client').val();
        var word = $(this).find('.input-search-client').val();
        var res = false;
        if(word !== ''){
            //var options = $('.select_client_id').children();
            var options = $(this).parent().find('.select_client_id').children();
            $.each(options,function(){
                if($(this).text().toLowerCase().search(word.toLowerCase())>=0){
                    var bt = $('<button class="btSelectSearch">' + $(this).text() + '</button></li>');
                    $('.resultSearch').append(bt);
                    bt.on('click',selectClient);
                    res = true;
                }
            });
            if(!res){
                $('.resultSearch').append($('<span>No Results</span>'));
            }
        }
    }
    
    
    function selectClient(){
        var nameClient = $(this).text();
        var options = $('.select_client_id').children();
        options.removeAttr('selected');
        $.each(options,function(){
            if($(this).text() === nameClient){
                $(this).attr('selected','selected');
            }
        });
    }