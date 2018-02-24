$(document).ready(function(){
    
    $(".about .read-more").on('click', verHistoria);
    
    function verHistoria(e){
        e.preventDefault();
        $('#more-about').toggle('historia-visible');
    }
    
});