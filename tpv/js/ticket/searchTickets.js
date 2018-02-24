$(document).ready(function(){
    $('#search').on('click', function(){
        $(".blur").css('filter', 'blur(10px)')
        $("#modalSearch").css('display', 'block');
    });
    $(".close").click(function() {
        $(".blur").css('filter', 'blur(0px)')
        $("#modalSearch").css('display', 'none');
        obtainData();
    });
    
    $('#BDate').on('click', function(){
        obtainTickets($('#dateSearch').val());
        $('#criterio').val($('#dateSearch').val());
    });
    
    $('#BText').on('click', function(){
        obtainTickets($('#textSearch').val());
        $('#criterio').val($('#dateSearch').val());
    });
    
    function obtainTickets(criterio){
        $('#list_ticket_search').empty();
        $.ajax({
            url: 'ticket_ajax/searchTicket',
            type: 'post',
            dataType: 'json',
            data: {
                criterio: criterio
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
                +'<a class="bt-action edit editar" data-id="'+ json.data[i].id +'"><i class="fa fa-folder-open" aria-hidden="true"></i></a>'
                +'<a class="bt-action remove borrar" data-id="'+ json.data[i].id +'"><i class="fa fa-times"></i></a>'
                +'</div></th>'
                +'</tr>');
                $('#list_ticket_search').append(ticket);
            }
            add();
        }).fail(function(){
            
        });
    }
    
    function add(){
        $('.borrar').on('click', function(){
            var id = $(this).data('id');
            $.ajax({
                url: 'ticket_ajax/removeTicket',
                type: 'post',
                dataType: 'json',
                data: {
                    id: id
                }
            }).done(function(json){
                //alert('Borrado');
                obtainTickets($('#criterio').val());
            }).fail(function(){
                alert('Fallo');
            })
        });
        $('.editar').on('click', function(){
            $(".blur").css('filter', 'blur(10px)');
            $("#modalSearch").css('display', 'none');
            $("#modalEdit").css('display', 'block');
            var id = $(this).data('id');
            getDetails(id);
        });
    }
});