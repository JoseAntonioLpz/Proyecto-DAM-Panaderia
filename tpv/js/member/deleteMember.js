$(document).ready(function(){
    $('.borrar').on('click', function(e){
        if(!confirm('¿Estas seguro que desea borrar a este usuario?')){
            e.preventDefault();
        }
    })
})