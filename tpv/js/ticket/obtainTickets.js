$(document).ready(function(){
    
    obtainData();
    // Cuando hace click en la X oculta.
    $(".close").click(function() {
        $(".blur").css('filter', 'blur(0px)')
        $("#modalEdit").css('display', 'none');
        reloadTableDetail();
    });
    
    $(".close").click(function() {
        $(".blur").css('filter', 'blur(0px)')
        $("#modalConfirm").css('display', 'none');
    });
    
    
    $('#clean').on('click', function() {
        if(confirm('The tickets without products are about to be removed.')){
            $.ajax({
                url: 'ticket_ajax/clean_tickets',
                type: 'post',
                dataType: 'json',
            }).done(function(json) {
                obtainData();
            }).fail(function() {
                alert('fallo');
            });
        }
    });
    
    $("#confirmBorrar").on('click', function() {
        removeTicket($(this).data('id'));
        $(".blur").css('filter', 'blur(0px)')
        $("#modalConfirm").css('display', 'none');
    });
    
    //********************************************
    
    /*$("#confirmBorrarNull").on('click', function() {
        removeTicket($(this).data('id'));
        $(".blur").css('filter', 'blur(0px)')
        $("#modalConfirmNull").css('display', 'none');
    });
    //here
    $("#confirmBorrar").on('click', function() {
        removeTicket($(this).data('id'));
        $(".blur").css('filter', 'blur(0px)')
        $("#modalConfirm").css('display', 'none');
    });*/
    
    
    //********************************************
    
    $('.order').on('click' , function() {
        $('#order').val($(this).data('order'));
        $(this).parent().children('.orderSelect').removeClass('orderSelect');
        $(this).addClass('orderSelect');
        obtainData();
    });
});

function getDetails(id){
    $.ajax(
        {
            url: 'ticket_detail_ajax/get_details',
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
                            +'<td><a class="removeDetails btnDelete" data-id="'+ json.data[i].id +'">Remove</a></td>'
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

function obtainData(){
    //var child = $('<tr><td>ID</td><td>Date</td><td>Miembro</td><td>Nombre</td><td>Apellidos</td><td>DNI</td><td>Borrar</td><td>Detalles</td></tr>');
    $('#list_ticket tbody').empty();
    //$('#list_ticket').append(child);
    
    $.ajax({
        url: 'ticket_ajax/getAllTicketsJoin',
        type: 'post',
        dataType: 'json',
        data: {
            page: $('#paginacion').data('page'),
            order: $('#order').val()
        }
    }).done(function(json){
        for (var i = 0; i < json.data.length; i++) {
            var ticket = $('<tr>'
            +'<th class="medium">' + json.data[i].id + '</th>'
            +'<th class="medium">' + json.data[i].date + '</th>'
            +'<th class="medium">' + json.data[i].login +'</th>'
            +'<th class="medium">' + json.data[i].id_client +'</th>'
            +'<th class="medium">' + json.data[i].name + '</th>'
            +'<th class="medium">' + json.data[i].surname +'</th>'
            +'<th class="medium">' + json.data[i].tin +'</th>'
            +'<th class="medium"><div class="actions">'
            +'<a class="bt-action edit editar" data-id="'+ json.data[i].id +'">Details</a>'
            +'<a class="bt-action remove borrar" data-id="'+ json.data[i].id +'">Remove</a>'
            +'</div></th>'
            +'</tr>');
             $('#list_ticket tbody').append(ticket);
        }
        addEvent();
        addPagination(json.pagination);
    }).fail(function(){
        alert('Esto ha fallado');
    });
}

    function addEvent(){
        $('.borrar').on('click', function(){
            $(".blur").css('filter', 'blur(10px)')
            $("#modalConfirm").css('display', 'block');
            $('#confirmBorrar').data('id',$(this).data('id'));
            /*
            */
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
        var first = $('<a class="paginationA" data-page="' + pagination.first + '">First</a>')
        $('#paginacion').append(first);
        for(var i = 0; i < pagination.range.length; i++){
            if($('#paginacion').data('page') === pagination.range[i]){
                var child = $('<a class="paginationA active" data-page="' + pagination.range[i] + '">' + pagination.range[i] + '</a>');
            }else{
                var child = $('<a class="paginationA" data-page="' + pagination.range[i] + '">' + pagination.range[i] + '</a>');
            }
            
            $('#paginacion').append(child);
        }
        
        var last = $('<a class="paginationA" data-page="' + pagination.last + '">Last</a>')
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
            if(!confirm('Are you sure to remove this details?')){
                return;
            }
            removeDetails(id);
        });
    }
    
    function reloadTableDetail(){
        var child = $('<tr>'
                    +'<td>Id</td>'	
                    +'<td>Price</td>'	
                    +'<td>Quantity</td>' 	
                    +'<td>Product</td>'
                    +'<td>Remove</td>'
                +'</tr>');
        $('#details_table').empty();
        $('#details_table').append(child);
    }
    
    function removeTicket(id){
        $.ajax({
            url: 'ticket_ajax/removeTicket',
            type: 'post',
            dataType: 'json',
            data: {
                id: id
            }
        }).fail(function(){
            alert('Fallo');
        }).always(function(){
            obtainData();
        });
    }
    
    function removeDetails(id){
        $.ajax({
            url: 'ticket_detail_ajax/removeTicketDetails',
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
    }