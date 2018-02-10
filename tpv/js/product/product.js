$(document).ready(function() {

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
        console.log(page);
        $('#productBox').empty();

        $.ajax({
            url: 'index.php',
            type: 'get',
            dataType: 'json',
            data: {
                ruta: 'product_ajax',
                accion: 'getAllProducts',
                idfamily: idfamily,
                text: text,
                page: page
            }
        }).done(
            function(json) {
                console.log(json.list);
                productList = json.list;
                
                // Muestra la primera página de la lista de productos.
                //displayProducts(0);
                
                for (var i in productList) {
                    var product = productList[i];
                    createProduct(product);
                }
                initEvents();
            }
        ).fail(
            function(json) {
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
            $('#preview').attr('src', '?ruta=product&accion=showImage&id=' + id + '');
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
    }
    /****************************************** _product_list.html */
    function loadModal(id) {
        $.ajax({
            url: 'index.php',
            type: 'get',
            dataType: 'json',
            data: {
                ruta: 'product_ajax',
                accion: 'getDetailsProduct',
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
            $(".info").text("Sube una imagen menor de 2MB.")
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
            '<div class="pimg" style="background-image: url(?ruta=product&accion=showImage&id=' + id + ');"></div>' +
            '<div class="pdetails">' +
            '<h3>' + name + '</h3>' +
            '<div class="pfamily">' + idfamily + '</div>' +
            '<p class="pprice">' + price + '</p>' +
            '<p>' + description + '</p>' +
            '</div>' +
            '<div class="pbuttons">' +
            '<button class="btnEdit" data-id="' + id + '"> Editar </button>' +
            '<button class="btnDelete" data-id="' + id + '"> Borrar </button>' +
            '</div>' +
            '</div>';
        $('#productBox').append(div);
    }

    // Crea un div fantasma para arreglar la cuadrícula flex.
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
        $('#image').val('');
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

    function deleteProduct(id) {
        $.ajax({
            url: 'index.php',
            type: 'get',
            dataType: 'json',
            data: {
                ruta: 'product_ajax',
                accion: 'deleteProduct',
                id: id
            }
        }).done(
            function(json) {
                getAll();
            }
        ).fail(
            function(json) {
                console.log("Hubo un error.");
            }
        );
    }


    $("#editImage").click(function(){
        var file = $(this).closest('form');
        console.log (file[0]);
        $.ajax({
            url: "index.php?ruta=product_ajax&accion=uploadImg",
            type: "post",             
            data: new FormData(file[0]), // Formulario que contiene el archivo de imagen
            contentType: false,       // Tipo de contenido que se envía al servidor
            cache: false,             // To unable request pages to be cached
            processData:false        // Para enviar documento DOM o archivos sin procesar estando en false.
        }).done(
            function(data) {
                $(".info").text(data.msgimage);
                if($(".info").text().indexOf("Error") != -1){
                    $(".info").addClass("error");
                }else{
                    $(".info").removeClass("error");
                }
            }
        ).fail(
            function(data) {
                $(".info").text("No se puedo subir la imagen.");
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
    $("#image").change(function(){
        readURL(this);
    });

    // Guardar producto editado
    $("#editProduct").click(function() {
        /***********************Subir datos normales***************************/
        var id = $("#id").val();
        var idfamily = $("#family").val();
        var product = $("#product").val();
        var price = $("#price").val();
        var description = $("#description").val();
        $.ajax({
            url: 'index.php',
            type: 'post',
            dataType: 'json',
            data: {
                ruta: 'product_ajax',
                accion: 'saveDetailsProduct',
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
                getAll();
            }
        ).fail(
            function(json) {
                console.log("Hubo un error.");
            }
        );

    });

    /*******************************************/
    /****************************************** _product_insert.html */
    var count = 2;
    $('#oneMoreProduct').click(function() {
        var newProduct = '<input type="file" name="img[]" />' +
            '<select id="idfamily_' + count + '" name="idfamily[]">' +
            '<option value="1">Pan</option>' +
            '<option value="2">Bollería</option>' +
            '<option value="3">Croissantería</option>' +
            '<option value="4">Navidad</option>' +
            '<option value="5">Otros</option>' +
            '</select>' +
            '<input type="text" id="product_' + count + '" name="product[]" value="" />' +
            '<input type="text" id="price_' + count + '" name="price[]" value="" />' +
            '<textarea id="description_' + count + '" name="description[]" value=""></textarea>' +
            '<hr>';
        $('#newProducts hr').last().after(newProduct);
        count++;
    });
});
