$(document).ready(function(){
    $('#form').on('submit' , function (e) {
        var login = $('#login').val();
        var pass = $('#clave').val();
        var passRep = $('#claveRep').val();
    
        var passR = true;
        var passV = true;
        
        if(pass !== '' && !pass !== null){
            passR = validatePass(pass, passRep);
            passV = regexValidation(/^(?=.*\d).{4,8}$/ , pass);
        }
        
        if(!passV ||  !passR  || !regexValidation(/^[a-z\d_]{4,15}$/i , login)){
            e.preventDefault();
        }
    });
    
    
    function validatePass(pass , passRep){
        var res = false;
        if(pass === passRep){
            res = true;
        }
        return res;
    }
    
    function regexValidation(regex, palabra){
        var res = false;
        if(regex.test(palabra)){
            res = true;
        }
        return res;
    }
});