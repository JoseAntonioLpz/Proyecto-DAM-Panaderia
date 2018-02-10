$(document).ready(function(){
    $('.btedit').on('click',hacerEditable);
    
    function hacerEditable(){
        quitarDemasEditables();//quito editable a tds que ya están editables
        var tds = $(this).parent().siblings();
        tds.addClass('editable');
        var cont = 1;
        tds.each(function(){//por cada td creo un input con el valor de su texto
            var input = $('<input type="text" class="loquesea" name="' + $('#col'+cont).text().toLocaleLowerCase() + '" value="' + $(this).text() + '">');
            cont++;
            $(this).text('');
            $(this).append(input);
        });
        $('.btedit').on('click',hacerEditable);
        $(this).off();
        $(this).on('click',quitarEditable);
    }
    
    function quitarEditable(){
        var tds = $(this).parent().siblings();
        tds.each(function(){//por cada input reemplazo input por texto
            $(this).text($(this).find('input').val());
        });
        $(this).off();
        $(this).on('click',hacerEditable);
    }
    
    function quitarDemasEditables(){//quito los demás tds editables
        var tds = $('.editable');
        tds.each(function(){
            $(this).text($(this).find('input').val());
        });
        tds.removeClass('editable');
    }
    
});