$(document).ready(function() {
    $.ajax({
            url: 'index.php',
            type: 'get',
            dataType: 'json',
            data: {
                ruta: 'product_ajax',
                accion: 'block'
            }
        }).done(
            function(data) {
                var status = data.status;
                console.log(status);
                if (status == 'true'){
                    $(".blur").css('filter', 'blur(40px)');
                    $("#modalBlock").css('display', 'block');
                    blockDangerousKeys();
                }else{
                    $(".blur").css('filter', 'blur(0px)');
                    $("#modalBlock").css('display', 'none');
                    unblockDangerousKeys();
                }
            }
        ).fail(
            function() {
                console.log("Hubo un error.");
            }
        );
        
    $("#passblock").change(function() {
        $("#unblock").removeClass("errorShake");
    });
        
    $("#unblock").click(function() {
        var pass = $("#passblock").val();
        
        // Obtener contraseña XML y comparar con var pass.
        var ok = false;
        if (pass != ''){
            $.ajax({
                url: 'index.php',
                type: 'get',
                dataType: 'json',
                data: {
                    ruta: 'product_ajax',
                    accion: 'block',
                    pass: pass,
                    status: false
                }
            }).done(
                function(data) {
                    var status = data.status;
                    console.log(status);
                    if (status == 'false'){
                        $(".blur").css('filter', 'blur(0px)');
                        $("#modalBlock").css('display', 'none');
                        unblockDangerousKeys();
                    }else{
                        $("#unblock").addClass("errorShake");
                    }
                }
            ).fail(
                function() {
                    console.log("Hubo un error.");
                    $("#unblock").removeClass("errorShake");
                    $("#unblock").addClass("errorShake");
                }
            );
        }
    });
    
    
    $("#blockscreen").click(function() {
        $("#passblock").val('');
        $.ajax({
            url: 'index.php',
            type: 'get',
            dataType: 'json',
            data: {
                ruta: 'product_ajax',
                accion: 'block',
                status: true
            }
        }).done(
            function(data) {
                $(".blur").css('filter', 'blur(40px)');
                $("#modalBlock").css('display', 'block');
                blockDangerousKeys();
            }
        ).fail(
            function() {
                console.log("Hubo un error.");
            }
        );
    });
    
    function unblockDangerousKeys(){
        $(document).unbind();
    }
    
    function blockDangerousKeys(){
        $(document).keypress(function (evt) {
        var keycode = evt.charCode || evt.keyCode;
        if (keycode >= 111 && keycode <=123) { //Enter key's keycode
            $("#unblock").attr("style", "border: 2px solid red");
            setTimeout(function(){
                $("#unblock").attr("style", "border: 2px solid white");
            }, 200);
            return false;
        }
        });
        $(document).on("contextmenu",function(){
            $("#unblock").attr("style", "border: 2px solid red");
            setTimeout(function(){
                $("#unblock").attr("style", "border: 2px solid white");
            }, 200);
            return false;
        });
    }
});