$(document).ready(function() {
    $.ajax({
        url: 'product_ajax/block',
        type: 'get',
        dataType: 'json',
    }).done(
        function(data) {
            var status = data.status;
            console.log(status);
            if (status == 'true') {
                $(".blur").css('filter', 'blur(40px)');
                $("#modalBlock").css('display', 'block');
                blockDangerousKeys();
            }
            else {
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
        if (pass != '') {
            $.ajax({
                url: 'product_ajax/block',
                type: 'get',
                dataType: 'json',
                data: {
                    pass: pass,
                    status: false
                }
            }).done(
                function(data) {
                    var status = data.status;
                    console.log(status);
                    if (status == 'false') {
                        $(".blur").css('filter', 'blur(0px)');
                        $("#modalBlock").css('display', 'none');
                        unblockDangerousKeys();
                    }
                    else {
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
            url: 'product_ajax/block',
            type: 'get',
            dataType: 'json',
            data: {
                status: true
            }
        }).done(
            function(data) {
                $(".blur").css('filter', 'blur(40px)');
                $("#modalBlock").css('display', 'block');

                //se quedaban residuos en la ventana, asi que borro todo menos el span donde se pide la contraseña
                $('#modalBlock .modal-content').find('span').siblings().remove();

                blockDangerousKeys();
            }
        ).fail(
            function() {
                console.log("Hubo un error.");
            }
        );
    });

    function unblockDangerousKeys() {
        $(document).unbind();
    }

    function blockDangerousKeys() {
        $(document).keydown(function(evt) {
            var keycode = evt.which;
            if (keycode >= 111 && keycode <= 123) { //Enter key's keycode
                $("#unblock").attr("style", "border: 2px solid red");
                setTimeout(function() {
                    $("#unblock").attr("style", "border: 2px solid white");
                }, 200);
                return false;
            }
        });
        $(document).on("contextmenu", function() {
            $("#unblock").attr("style", "border: 2px solid red");
            setTimeout(function() {
                $("#unblock").attr("style", "border: 2px solid white");
            }, 200);
            return false;
        });
    }

    /* Ya que el bloqueo está en todos lados pondré aquí el código de las tostadas de error. */
    $('#error, .error').on("DOMSubtreeModified", function() {
        var that = $(this);
        $(this).addClass("show");
        setTimeout(function() {
            that.removeClass("show");
            that.text('');
            clearTimeout(this);
        }, 3000);
    });
    
    $('#error, .error').click(function() {
        $(this).removeClass("show");
        $(this).text('');
    });
});
