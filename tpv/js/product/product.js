$(document).ready(function() {
    
    if ($('#error').text() != ''){
        $("#error").trigger("DOMSubtreeModified");
    }
    
    // Lista de productos
    var productList = null;
    // Página actual, pero no el número de esta sino la cuenta del
    // primer producto mostrado. Se incrementa en 9.
    var page = 0;
    
    // Tiempo de espera para ver la animacion de carga.
    // setTimeout(
    //     function(){
            getAll(0, null, page);
        // }, 1000);
    
    // Gráfico de carga
    var loading = '<div class="loadbox">'+
                        '<div class="loading"></div>'+
                        '<div class="loading"></div>'+
                        '<div class="loading"></div>'+
                    '</div>';
    /**
     * 
     */
     
    $("#pagBefore").click(function() {
        page -= 9;
        if (page < 0){
            page = 0;
        }
        // $('#productBox').empty();
        // displayProducts(page);
        getAll(0, null, page);
    });
    
    $("#pagAfter").click(function() {
        page = page + 9;
        console.log(page);
        // if (page >= productList.length){
        //     $("#pagAfter").addClass('disabled');
        //     page = page - 9;
        // }
        // $('#productBox').empty();
        // displayProducts(page);
        getAll(0, null, page);
    });
    
    function getAll(idfamily, text, page) {
        $('#productBox').empty();
        $("#productBox").append(loading);

        $.ajax({
            url: 'product_ajax/getAllProducts',
            type: 'get',
            dataType: 'json',
            data: {
                idfamily: idfamily,
                text: text,
                page: page
            }
        }).done(
            function(json) {
                productList = json.list;
                $('#productBox').empty();
                // Muestra la primera página de la lista de productos.
                //displayProducts(0);
                
                for (var i in productList) {
                    var product = productList[i];
                    createProduct(product);
                }
                initEvents();
                
                var previous = $(".pbox").length;
                var multipleFound = false;
                var nearest = previous;
                while(!multipleFound){
                    var n = nearest % 3;
                    if (n == 0){
                        multipleFound = true;
                    }else{
                        nearest++;
                    }
                }
                console.log(nearest);
                var nGhosts = nearest - previous;
                for (var i = 0; i < nGhosts; i++){
                    createGhost();
                }
            }
        ).fail(
            function(json) {
                $('#productBox').empty();
                console.log(json.list);
                console.log("Hubo un error.");
            }
        );
    }

    function initEvents() {
        // Cuando hace click en editar muestra la ventana.
        $(".btnEdit").click(function() {
            $(".blur").css('filter', 'blur(10px)');
            $("#modalEdit").css('display', 'block');

            
            var id = $(this).data("id");
            loadModal(id);
            
            // Limpia la imagen anterior
            $('#preview').attr('src', 'product/showImage?id=' + id + '');
        });

        $(".btnDelete").click(function() {
            var that = $(this);

            if (that.hasClass("deleting")) {
                // Si pulsa el botón y este ya tiene la clase deleting significa que la cuenta
                // atrás ya comenzó y tiene la oportunidad de borrar el producto.
                that.removeClass("deleting");
                var id = that.data("id");
                deleteProduct(id);
            }
            else {
                // Inicia el temporizador y la animación regresiva.
                that.addClass("deleting");
                setTimeout(function() {
                    that.removeClass("deleting");
                }, 3000);
            }
        });

        // Cuando hace click en la X oculta.
        $(".close").click(function() {
            $(".blur").css('filter', 'blur(0px)')
            $("#modalEdit").css('display', 'none');
        });
        
        // Cierra el modal cuando click fuera
        $("#modalEdit").click(function(e) {
            if (e.target.id == "modalEdit"){
                $(".blur").css('filter', 'blur(0px)')
                $("#modalEdit").css('display', 'none');
            }
        });
    }
    /****************************************** _product_list.html */
    function loadModal(id) {
        $.ajax({
            url: 'product_ajax/getDetailsProduct',
            type: 'get',
            dataType: 'json',
            data: {
                id: id
            }
        }).done(
            function(json) {
                console.log(json.single);
                createEdit(json.single);
            }
        ).fail(
            function(json) {
                console.log(json.single);
                console.log("Hubo un error.");
            }
        );
        
        if ($(".info").text() == ''){
            $(".info").text("Upload an image smaller than 2MB.")
        }
        
    }
    
    function displayProducts(numberp){
        var limit = 0;
        var ghosts = 0;
        for (var i in productList) {
            if (limit >= numberp && limit < (numberp+10)){
                var product = productList[i];
                createProduct(product);
            }
            limit++;
        }
        initEvents();
        // createGhost(ghosts);
    }

    function createProduct(product) {
        var id = product.id;
        var idfamily = product.idfamily;
        var name = product.product;
        var price = product.price;
        var description = product.description;

        var div = '<div class="pbox">' +
            '<div class="pimg" style="background-image: url(product/showImage?id=' + id + ');"></div>' +
            '<div class="pdetails">' +
            '<h3>' + name + '</h3>' +
            '<div class="pfamily">' + idfamily + '</div>' +
            '<p class="pprice">' + price + '</p>' +
            '<p>' + description + '</p>' +
            '</div>' +
            '<div class="pbuttons">' +
            '<button class="btnEdit" data-id="' + id + '"> Edit </button>' +
            '<button class="btnDelete" data-id="' + id + '"> Remove </button>' +
            '</div>' +
            '</div>';
        $('#productBox').append(div);
    }

    // Crea un div fantasma para arreglar la cuadrícula flex. No usado.
    function createGhost(loops){
        var i = 0;
        while(i < loops){
            var div = '<div class="pbox" style="visibility: hidden;"></div>';
            $('#productBox').append(div);
            i++;
        }
    }

    function createEdit(product) {
        var id = product.id;
        var idfamily = product.idfamily;
        var name = product.product;
        var price = product.price;
        var description = product.description;
        $('#id').val(id);
        $('#image0').val('');
        // Comprueba cada <option> y si tiene el valor de la familia se autoselecciona.
        $('#family option').each(function() {
            if ($(this).val() === idfamily) {
                $(this).attr("selected", "selected");
            }
            else {
                $(this).attr("selected", null);
            }
        });
        $('#product').val(name);
        $('#price').val(price);
        $('#description').val(description);
    }
    
    function createGhost(){
        var div = $('<div class="pbox ghost">' +
            '</div>');
        $('#productBox').append(div);
    }

    function deleteProduct(id) {
        $.ajax({
            url: 'product_ajax/deleteProduct',
            type: 'get',
            dataType: 'json',
            data: {
                id: id
            }
        }).done(
            function(json) {
                getAll(0, null, page);
            }
        ).fail(
            function(json) {
                console.log("Hubo un error.");
            }
        );
    }


    $("#editImage").click(function(){
        var file = $(this).closest('form');
        $(".info").after('<div class="loadbox mini">'+
                '<div class="loading"></div>'+ 
                '<div class="loading"></div>'+
                '<div class="loading"></div>'+
            '</div>');
        
        $.ajax({
            url: "product_ajax/uploadImg",
            type: "post",             
            data: new FormData(file[0]), // Formulario que contiene el archivo de imagen
            contentType: false,       // Tipo de contenido que se envía al servidor
            cache: false,             // To unable request pages to be cached
            processData:false        // Para enviar documento DOM o archivos sin procesar estando en false.
        }).done(
            function(data) {
                console.log(data.msgimage);
                $(".loadbox").remove();
                $(".info").text(data.msgimage);
                if($(".info").text().indexOf("Error") != -1){
                    $(".info").addClass("errorr");
                }else{
                    $(".info").removeClass("errorr");
                }
            }
        ).fail(
            function(data) {
                $(".info").text("The image can't be upload.");
            }
        );
    });
    
    /**
     * Previsualizar imagen antes de subirla
     */
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    function asociaEvento(id) {
        $(id).change(function(){
            var filename = $(this).val().split('\\').pop();
            $(id + " + label span").text(filename);
            readURL(this);
        });
    }
    asociaEvento("#image0");
    

    // Guardar producto editado
    $("#editProduct").click(function() {
        /***********************Subir datos normales***************************/
        var id = $("#id").val();
        var idfamily = $("#family").val();
        var product = $("#product").val();
        var price = $("#price").val();
        var description = $("#description").val();
        $.ajax({
            url: 'product_ajax/saveDetailsProduct',
            type: 'post',
            dataType: 'json',
            data: {
                id: id,
                idfamily: idfamily,
                product: product,
                price: price,
                description: description
            }
        }).done(
            function(json) {
                $(".blur").css('filter', 'blur(0px)')
                $("#modalEdit").css('display', 'none');
                getAll(0, null, page);
            }
        ).fail(
            function(json) {
                console.log("Hubo un error.");
            }
        );

    });

    /*******************************************/
    /****************************************** _product_insert.html */
    var families = '';
    var count = 1;
    
    function getFamilies(){
        $.ajax({
            url: 'family',
            type: 'get',
            dataType: 'json'
        }).done(function(json) {
            families = json.data;
        }).fail(
            function() {
                console.log("Esto ha fallado.")
            }
        );
    }
    
    if ($('#oneMoreProduct').length){
        getFamilies();
    }
    
    $('#oneMoreProduct').click(function() {
        var newProduct = '<div class="newProductContainer">' +
            '<input class="styleImage" type="file" id="image' + count + '" name="img['+count+']" />' +
            '<label for="image' + count + '" class="medium">'+
                '<p><i class="fa fa-image" aria-hidden="true"></i></p>'+
                '<span></span>'+
            '</label>' +
            '<select id="idfamily_' + count + '" name="idfamily['+count+']" class="medium">';
            
            for (var i = 0; i < families.length; i++) {
                newProduct += '<option value="' + families[i].id + '">' + families[i].family + '</option>';
            }
            newProduct += '</select>' +
            '<input type="text" id="product_' + count + '" name="product['+count+']" value="" class="medium" placeholder="Name"/>' +
            '<input type="text" id="price_' + count + '" name="price['+count+']" value="" class="medium" placeholder="Price"/>' +
            '<textarea id="description_' + count + '" name="description['+count+']" value="" class="medium" placeholder="Description"></textarea>' +
            '<button type="button" class="removeNewProduct medium  btnDelete">Remove</button>' +
            '</div>';
        $('#newProducts div').last().after(newProduct);
        asociaEvento("#image" + count);
        count++;
        $('#newProducts .removeNewProduct').click(function() {
            $(this).closest(".newProductContainer").remove();
        });
    });
    
});
