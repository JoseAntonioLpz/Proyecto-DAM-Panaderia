$(document).ready(function(){
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
        function(json){
            var data = json.data;
            for(var i = 0; i < data.length; i++){
                var li = $('<div><a>' + data[i].family +'</a></div>');
                add_event(data[i].family, li);
                familias.append(li);
            }
        }
    ).fail(
        // No recibo la respuesta y hay un error
        function(){
            alert('Esto ha fallado');
        }
    ).always(
        // Se ejecuta siempre
        function(){
            
        }
    );
    
    function add_event(nombre, campo){
        campo.on('click', function(e){
            alert(nombre);
        });
    }
})