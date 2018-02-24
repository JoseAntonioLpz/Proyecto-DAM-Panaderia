$(document).ready(function(){
    $('.borrar').on('click', function(e){
        if(!confirm('Do you really want to remove this user?')){
            e.preventDefault();
        }
    })
})