$(document).bind('keypress', function(e) {
    if(e.keyCode==13){
         $('#login').trigger('click');
     }
});

$('#login').click(function(e){
    if ($.trim($("#email").val()) === "" || $.trim($("#password").val()) === "") {
        $("#notif1").css("display", "block");
        return false;
    }
    else{
        var em = document.getElementById("email").value;
        var last_email_part = em.substr(em.length - 17);
        var urls;
        if(last_email_part === "techmasters.co.zm")
        {
            urls = "access/core/CoreTech.php";
        }
        else
        {
            urls = "access/core/Function.php";
        }
        $("#notif2").css("display", "block");
        var btn = document.getElementById('login');
        btn.disabled = true;
        e.preventDefault();
        $("#spinner").css("display", "block");
        $("#arrow").css("display", "none");
        $.ajax({
            type: "post",
            url: urls,
            data: $("form").serialize(),
            cache: false,
            processData: false,
            success: function (strMessage) {
                console.log(strMessage);
                // $('#saver').removeAttr('disabled');
                var xx = strMessage;
                if (xx !== "Wala" && xx !== "Non Existing" && xx !== "Error") 
                {
                    $("#notif2").css("display", "none");
                    $("#notif3").css("display", "none");
                    $("#notif4").css("display", "none");
                    $("#notif5").css("display", "block");
                    var page = xx;
                    setTimeout(function () {
                        window.location.href = page;
                    }, 2500);
                } 
                else if (xx === "Wala") 
                {
                    $("#notif2").css("display", "none");
                    $("#notif3").css("display", "block");
                    btn.disabled = false;
                    $("#spinner").css("display", "none");
                    $("#arrow").css("display", "block");
                } 
                else if (xx === "Non Existing") 
                {
                    $("#notif2").css("display", "none");
                    $("#notif3").css("display", "block");
                    btn.disabled = false;
                    $("#spinner").css("display", "none");
                    $("#arrow").css("display", "block");
                } 
                else if (xx === "Error") 
                {
                    $("#notif2").css("display", "none");
                    $("#notif4").css("display", "block");
                    btn.disabled = false;
                    $("#spinner").css("display", "none");
                    $("#arrow").css("display", "block");
                }
          },
        });
    }
});

$('#newpassword').keyup(function() {
    // keyup event code here
    var pswd = $(this).val();
    //validate letter
    if ( pswd.match(/[A-z]/) ) {
        $('#letter').removeClass('invalid').addClass('valid');
    } else {
        $('#letter').removeClass('valid').addClass('invalid');
    }
    
    //validate capital letter
    if ( pswd.match(/[A-Z]/) ) {
        $('#capital').removeClass('invalid').addClass('valid');
    } else {
        $('#capital').removeClass('valid').addClass('invalid');
    }
    
    //validate number
    if ( pswd.match(/\d/) ) {
        $('#number').removeClass('invalid').addClass('valid');
    } else {
        $('#number').removeClass('valid').addClass('invalid');
    }
    //validate the length
    if ( pswd.length < 8 ) {
        $('#length').removeClass('valid').addClass('invalid');
    } else {
        $('#length').removeClass('invalid').addClass('valid');
    }
});

$('#conpassword').keyup(function() {
    // keyup event code here
    var pswd = $(this).val();
    //validate letter
    if ( pswd.match(/[A-z]/) ) {
        $('#letter').removeClass('invalid').addClass('valid');
    } else {
        $('#letter').removeClass('valid').addClass('invalid');
    }
    
    //validate capital letter
    if ( pswd.match(/[A-Z]/) ) {
        $('#capital').removeClass('invalid').addClass('valid');
    } else {
        $('#capital').removeClass('valid').addClass('invalid');
    }
    
    //validate number
    if ( pswd.match(/\d/) ) {
        $('#number').removeClass('invalid').addClass('valid');
    } else {
        $('#number').removeClass('valid').addClass('invalid');
    }
    //validate the length
    if ( pswd.length < 8 ) {
        $('#length').removeClass('valid').addClass('invalid');
    } else {
        $('#length').removeClass('invalid').addClass('valid');
    }
});

$('#change').click(function(e){
    if ($.trim($("#conpassword").val()) === "" || $.trim($("#newpassword").val()) === "" || $.trim($("#OGpassword").val()) === "") {
        $("#notif1").css("display", "block");
        return false;
    }
    else{
        $("#notif2").css("display", "block");
        var btn = document.getElementById('change');
        btn.disabled = true;
        e.preventDefault();
        $("#spinner").css("display", "block");
        $("#arrow").css("display", "none");
        $.ajax({
            type: "post",
            url: "access/core/Function.php",
            data: $("form").serialize(),
            cache: false,
            processData:false,
            success: function(strMessage) {
                console.log(strMessage);
                // $('#saver').removeAttr('disabled');
                var xx = strMessage;
                if (xx != 'Invalid' && xx != 'No Match' && xx != 'Error') {
                    $("#notif2").css("display", "none");
                    $("#notif5").css("display", "block");    
                    setTimeout(function(){
                        window.location.href = xx;
                    }, 2500); 
                }
                if (xx == 'Invalid') { 
                    $("#notif2").css("display", "none");
                    $("#notif3").css("display", "block");     
                }
                if (xx == 'No Match') { 
                    $("#notif2").css("display", "none");
                    $("#notif6").css("display", "block");     
                }
                if (xx == 'Error') {   
                    $("#notif2").css("display", "none");
                    $("#notif4").css("display", "block");    
                }
            }
        });
    }
});

$('#reset').click(function(e){
    if ($.trim($("#emailz").val()) === "") {
        $("#notif1").css("display", "block");
        return false;
    }
    else{
        var em = document.getElementById("emailz").value;
        var last_email_part = em.substr(em.length - 17);
        var urls;
        if(last_email_part === "techmasters.co.zm")
        {
            urls = "access/core/CoreTech.php";
        }
        else
        {
            urls = "access/core/Function.php";
        }
        $("#notif2").css("display", "block");
        var btn = document.getElementById('reset');
        btn.disabled = true;
        e.preventDefault();
        $("#spinner").css("display", "block");
        $("#arrow").css("display", "none");
        $.ajax({
            type: "post",
            url: urls,
            data: $("form").serialize(),
            cache: false,
            processData:false,
            success: function(strMessage) {
                console.log(strMessage);
                var xx = strMessage;
                if (xx == 'Back') {
                    $("#notif10").css("display", "block");   
                    setTimeout(function(){
                        window.location.href = "./";
                    }, 2500); 
                }
                if (xx == 'Error') {   
                    $("#notif2").css("display", "none");
                    $("#notif10").css("display", "none");
                    $("#notif3").css("display", "block");    
                }
            }
        });
    }
});