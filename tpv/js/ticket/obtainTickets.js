$(document).ready(function(){
    
    obtainData();
    
    function obtainData(){
        //var child = $('<tr><td>ID</td><td>Date</td><td>Miembro</td><td>Nombre</td><td>Apellidos</td><td>DNI</td><td>Borrar</td><td>Detalles</td></tr>');
        $('#list_ticket').empty();
        //$('#list_ticket').append(child);
        
        $.ajax({
            url: 'index.php?accion=getAllTicketsJoin&ruta=ticket_ajax',
            type: 'post',
            dataType: 'json',
            data: {
                page: $('#paginacion').data('page'),
                order: $('#order').val()
            }
        }).done(function(json){
            for (var i = 0; i < json.data.length; i++) {
                var ticket = $('<tr>'
                +'<th>' + json.data[i].id + '</th>'
                +'<th>' + json.data[i].date + '</th>'
                +'<th>' + json.data[i].login +'</th>'
                +'<th>' + json.data[i].id_client +'</th>'
                +'<th>' + json.data[i].name + '</th>'
                +'<th>' + json.data[i].surname +'</th>'
                +'<th>' + json.data[i].tin +'</th>'
                +'<th><div class="actions">'
                +'<a class="bt-action edit editar" href="#" data-id="'+ json.data[i].id +'"><i class="fa fa-folder-open" aria-hidden="true"></i></a>'
                +'<a class="bt-action remove borrar" href="#" data-id="'+ json.data[i].id +'"><i class="fa fa-times"></i></a>'
                +'</div></th>'
                +'</tr>');
                 $('#list_ticket').append(ticket);
            }
            addEvent();
            addPagination(json.pagination);
        }).fail(function(){
            alert('Esto ha fallado');
        });
    }
    
    function addEvent(){
        $('.borrar').on('click', function(){
            var id = $(this).data('id');
            $.ajax({
                url: 'index.php?accion=removeTicket&ruta=ticket_ajax',
                type: 'post',
                dataType: 'json',
                data: {
                    id: id
                }
            }).done(function(json){
                alert('Borrado');
            }).fail(function(){
                alert('Fallo');
            }).always(function(){
                obtainData();
            });
        });
        $('.editar').on('click', function(){
            $(".blur").css('filter', 'blur(10px)')
            $("#modalEdit").css('display', 'block');
            var id = $(this).data('id');
            getDetails(id);
        });
    }
    
    function addPagination(pagination){
        $('#paginacion').empty();
        var first = $('<a class="paginationA" href="#" data-page="' + pagination.first + '">First</a>')
        $('#paginacion').append(first);
        for(var i = 0; i < pagination.range.length; i++){
            if($('#paginacion').data('page') === pagination.range[i]){
                var child = $('<a class="paginationA active" href="#" data-page="' + pagination.range[i] + '">' + pagination.range[i] + '</a>');
            }else{
                var child = $('<a class="paginationA" href="#" data-page="' + pagination.range[i] + '">' + pagination.range[i] + '</a>');
            }
            
            $('#paginacion').append(child);
        }
        
        var last = $('<a class="paginationA" href="#" data-page="' + pagination.last + '">Last</a>')
        $('#paginacion').append(last);
        
        $('.paginationA').on('click', function() {
            $('#paginacion').data('page' , $(this).data('page'));
            obtainData();
        })
    }
    
    function addEventDetails(){
        $('.removeDetails').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            if(!confirm('¿Estas seguro que desea borrar este detalle?')){
                return;
            }
            $.ajax({
                
                url: 'index.php?accion=removeTicketDetails&ruta=ticket_detail_ajax',
                type: 'post',
                dataType: 'json',
                data: {
                    id: id
                }
                
            }).done(function(json) {
                //alert(json.data[0].res);
                var idTicket = json.data.idTicket;
                reloadTableDetail();
                getDetails(idTicket);
            }).fail(function(){
                alert('Fallo Details');
            });
        });
    }
    
    // Cuando hace click en la X oculta.
    $(".close").click(function() {
        $(".blur").css('filter', 'blur(0px)')
        $("#modalEdit").css('display', 'none');
        reloadTableDetail();
    });
    
    function reloadTableDetail(){
        var child = $('<tr>'
                    +'<td>Id</td>'	
                    +'<td>Price</td>'	
                    +'<td>Quantity</td>' 	
                    +'<td>Product</td>'
                +'</tr>');
        $('#details_table').empty();
        $('#details_table').append(child);
    }
    
    function getDetails(id){
        $.ajax(
            {
                url: 'index.php?accion=get_details&ruta=ticket_detail_ajax',
                type: 'post',
                dataType: 'json',
                data: {
                    id: id
                }
                
            }
        ).done(
            function(json){
                for(var i = 0; i < json.data.length; i++){
                    var tr = $('<tr>'
                                +'<td>' + json.data[i].id + '</td>' 	
                                +'<td>' + json.data[i].price + '</td>'	
                                +'<td>' + json.data[i].quantity + '</td>' 	
                                +'<td>' + json.data[i].product + '</td>'
                                +'<td><a class="removeDetails" href="#" data-id="'+ json.data[i].id +'">Borrar</a></td>'
                                +'</tr>');
                    $('#details_table').append(tr);
                }
                addEventDetails();
            }
        ).fail(
            function(){
                alert('error');
            }
        );
    }
    
    $('#clean').on('click', function() {
        if(confirm('¿Quiere eliminar los tickets sin productos?')){
            $.ajax({
                url: 'index.php?accion=clean_tickets&ruta=ticket_ajax',
                type: 'post',
                dataType: 'json',
            }).done(function(json) {
                obtainData();
            }).fail(function() {
                alert('fallo');
            });
        }
    });
    
    $('.order').on('click' , function() {
        $('#order').val($(this).data('order'));
        $(this).parent().children('.orderSelect').removeClass('orderSelect');
        $(this).addClass('orderSelect');
        obtainData();
    });
});