$(document).ready(function(){
    
    //validar formulario clientes
    $('#form-client').on('submit',validate);
    
    function validate(e){
        /*variables con funciones*/
        /*var name = validateLengthOnlyCharacters($('.name-client'),3);
        var surname = validateLengthOnlyCharacters($('.surname-client'),3);
        var tin = validateCIF($('.tin-client').val(),$('.tin-client'));
        var address = validateAddress($('.address-client'));
        //solo valida si se escribe algo
        if($('.postalcode-client').val() !== ''){
            var postalcode = validateLengthOnlyNumbers($('.postalcode-client'),5);    
        }
        if($('.province-client').val() !== ''){
            var province = validateLengthOnlyCharacters($('.province-client'),3);    
        }
        if($('.email-client').val() !== ''){
            var email = validateEmail($('.email-client'));    
        }
        
        if(name && surname && tin && address){
            if(typeof(postalcode) != "undefined" && !postalcode){
                e.preventDefault();
            }else if(typeof(province) != "undefined" && !province){
                e.preventDefault();
            }else if(typeof(email) != "undefined" && !email){
                e.preventDefault();
            }
        }else{
            e.preventDefault();
        }*/
        
        var lineInputs = $('.fields');
        $.each(lineInputs,function(){
            var name = validateLengthOnlyCharacters($(this).find('.name-client'),3);
            var surname = validateLengthOnlyCharacters($(this).find('.surname-client'),3);
            var tin = validateCIF($(this).find('.tin-client').val(),$(this).find('.tin-client'));
            var address = validateAddress($(this).find('.address-client'));
            //solo valida si se escribe algo
            if($(this).find('.postalcode-client').val() !== ''){
                var postalcode = validateLengthOnlyNumbers($(this).find('.postalcode-client'),5);    
            }
            if($(this).find('.province-client').val() !== ''){
                var province = validateLengthOnlyCharacters($(this).find('.province-client'),3);    
            }
            if($(this).find('.email-client').val() !== ''){
                var email = validateEmail($(this).find('.email-client'));    
            }
            
            if(name && surname && tin && address){
                if(typeof(postalcode) != "undefined" && !postalcode){
                    e.preventDefault();
                }else if(typeof(province) != "undefined" && !province){
                    e.preventDefault();
                }else if(typeof(email) != "undefined" && !email){
                    e.preventDefault();
                }
            }else{
                e.preventDefault();
            }
        });
    }
    
    //validar email
    function validateEmail(inputEmail){
        var pattern = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/;
        var rest = false;
        if(pattern.test(inputEmail.val())){
            rest = true;
            inputEmail.next('.error').text('');
        }else{
            inputEmail.next('.error').text('The mail must have a format: example@mail.com');
        }
        return rest;
    }
    
    //comprueba longitud y que solo sean letras
    function validateLengthOnlyCharacters(input,min){
        var rest = false;
        if(input.val().length >= min && isNaN(input.val())){
            rest = true;
            input.next('.error').text('');
        }else if(input.val().length >= min && !isNaN(input.val())){
            input.next('.error').text('Only characters');
        }else if(isNaN(input.val()) && input.val().length < min){
            input.next('.error').text('Minimum ' + min + ' characters');
        }else{
            input.next('.error').text('Only characters and minimum ' + min + ' length');
        }
        return rest;
    }
    
    //comprueba longitud y que solo sean números
    function validateLengthOnlyNumbers(input,lon){
        var rest = false;
        if(input.val().length===lon && !isNaN(input.val())){
            rest = true;
            input.next('.error').text('');
        }else if(input.val().length===lon && isNaN(input.val())){
            input.next('.error').text('Only numbers');
        }else if(!isNaN(input.val()) && input.val().length!==lon){
            input.next('.error').text(lon+' digits obligatorily');
        }else{
            input.next('.error').text('Only numbers and length '+lon);
        }
        return rest;
    }
    
    //validar DNI
    function validateDNI(dni,inputDNI){
        var rest = false;
        //var inputDNI = $('.tin-client');
        if(checkEstructureDNI(dni) && checkLetter(dni)){
            rest = true;
        }else if(!checkEstructureDNI(dni)){
            inputDNI.next('.error').text('Incorrect NIF');
        }else{
            inputDNI.next('.error').text('The letter is incorrect');
        }
        return rest;
    }
     
    function checkEstructureDNI(dni){
        var pattern = /^\d{8}[a-zA-Z]$/;
        var good = false;
        if(pattern.test(dni)){
            good = true;
        }
        return good;
    }
    
    function checkLetter(dni){
        var letters = ['T', 'R', 'W', 'A', 'G', 'M', 'Y', 'F', 'P', 'D', 'X', 'B', 'N', 'J', 'Z', 'S', 'Q', 'V', 'H', 'L', 'C', 'K', 'E']; 
        var dniNumber = dni.substr(0,8);
        var dniLetter = dni.charAt(dni.length-1).toLocaleLowerCase();
        var good = false;
        var rest = dniNumber % 23;
        if(dniLetter===letters[rest].toLocaleLowerCase()){
           good = true;
        }
        return good;
    }
    
    
    //valida un cif. si la estructura de cif falla comprueba si es un dni
    function validateCIF(cif,inputDNI){
    	//Quitamos el primer caracter y el ultimo digito
    	var valueCif=cif.substr(1,cif.length-2);
     
    	var suma=0;
     
    	//Sumamos las cifras pares de la cadena
    	for(i=1;i<valueCif.length;i=i+2)
    	{
    		suma=suma+parseInt(valueCif.substr(i,1));
    	}
     
    	var suma2=0;
     
    	//Sumamos las cifras impares de la cadena
    	var result = -1;
    	for(i=0;i<valueCif.length;i=i+2)
    	{
    		result=parseInt(valueCif.substr(i,1))*2;
    		if(String(result).length==1)
    		{
    			// Un solo caracter
    			suma2=suma2+parseInt(result);
    		}else{
    			// Dos caracteres. Los sumamos...
    			suma2=suma2+parseInt(String(result).substr(0,1))+parseInt(String(result).substr(1,1));
    		}
    	}
     
    	// Sumamos las dos sumas que hemos realizado
    	suma=suma+suma2;
     
    	var unidad = String(suma).substr(String(suma).length - 1, 1);
    	unidad=10-parseInt(unidad);
     
    	var primerCaracter=cif.substr(0,1).toUpperCase();
     
    	if(primerCaracter.match(/^[FJKNPQRSUVW]$/))
    	{
    		//Empieza por .... Comparamos la ultima letra
    		if(String.fromCharCode(64+unidad).toUpperCase()==cif.substr(cif.length-1,1).toUpperCase()){
    			return true;
    		}
    	}else if(primerCaracter.match(/^[XYZ]$/)){
    		//Se valida como un dni
    		var newcif;
    		if(primerCaracter=="X")
    			newcif=cif.substr(1);
    		else if(primerCaracter=="Y")
    			newcif="1"+cif.substr(1);
    		else if(primerCaracter=="Z")
    			newcif="2"+cif.substr(1);
    		return validateDNI(newcif);
    	}else if(primerCaracter.match(/^[ABCDEFGHLM]$/)){
    		//Se revisa que el ultimo valor coincida con el calculo
    		if(unidad==10)
    			unidad=0;
    		if(cif.substr(cif.length-1,1)==String(unidad))
    			return true;
    	}else{
    		//Se valida como un dni
    		return validateDNI(cif,inputDNI);
    	}
    	inputDNI.next('.error').text('CIF incorrecto');
    	return false;
    }
    
    //valida formato de dirección calle,nª
    function validateAddress(input){
        var pattern = /^[a-zA-z]*\,{1}[0-9]{1,3}$/;
        var rest = false;
        if(pattern.test(input.val())){
            rest = true;
            input.next('.error').text('');
        }else{
            input.next('.error').text('the address must have a format: street,nº');
        }
        return rest;
    }
    
    
    //pide confirmación para borrar un cliente
    $('.actions .remove-client').on('click',removeConfirm);
    
    
    function removeConfirm(e){
        e.preventDefault();
        
        $(".blur").css('filter', 'blur(10px)');
        $("#modalEdit").css('display', 'block');
        
        var message = $('<h3>¿Are you sure to remove this client?</h3>');
        var bts = $('<div class="actions">'+
                            '<a class="bt-action confirm" href="' + $(this).attr('href') + '"><i class="fa fa-check"></i></a>'+
                            '<a class="bt-action remove close"><i class="fa fa-times"></i></a>'+
                    '</div>');
        $('.modal-content').append(message);
        $('.modal-content').append(bts);
        
        // Cuando hace click en la X oculta.
        $(".close").click(function() {
            $(".blur").css('filter', 'blur(0px)')
            $("#modalEdit").css('display', 'none');
            $('.modal-content').children().remove();
        });
    }
    
    
    //función que añade campos al formulario para insertar varios clientes a la vez
    $('#add_more').on('click',function(){
        var fields = '<div class="fields">' + 
                        '<input class="name-client" type="text" placeholder="Name*" name="name[]" required> ' +
                        '<span class="error"></span>' +
                        '<input class="surname-client" type="text" placeholder="Surname*" name="surname[]" required>' +
                        '<span class="error"></span>' +
                        '<input class="tin-client" type="text" placeholder="CIF/NIF*" name="tin[]" required>' +
                        '<span class="error"></span>' +
                        '<input class="address-client" type="text" placeholder="Address*" name="address[]" required>' +
                        '<span class="error"></span>' +
                        '<input class="location-client" type="text" placeholder="Location" name="location[]">' +
                        '<span class="error"></span>' +
                        '<input class="postalcode-client" type="number" placeholder="Postal Code" name="postalcode[]">' +
                        '<span class="error"></span>' +
                        '<input class="province-client" type="text" placeholder="Province" name="province[]">' +
                        '<span class="error"></span>' + 
                        '<input class="email-client" type="email" placeholder="E-mail" name="email[]">' +
                        '<span class="error"></span>' +
                        '<a class="rm_field btnDelete">Delete</a></div>';
        
        $('#form-client').append(fields);
        
        //manejador de eventos para boton quitar campos
        $('.rm_field').on('click',removeField);
    });
    
    function removeField(e){
        e.preventDefault();
        $(this).parent('.fields').remove();
    }
});