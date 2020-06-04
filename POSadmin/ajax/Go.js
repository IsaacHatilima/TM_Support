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
    if ($.trim($("#conpassword").val()) === "" || $.trim($("#newpassword").val()) === "") {
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
            url: "../core/ChangePassword.php",
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
                        window.location.href = "./";
                    }, 2500); 
                }
                if (xx == 'Invalid') { 
                    $("#notif2").css("display", "none");
                    $("#notif3").css("display", "block"); 
                    btn.disabled = false;    
                }
                if (xx == 'No Match') { 
                    $("#notif2").css("display", "none");
                    $("#notif6").css("display", "block");  
                    btn.disabled = false;    
                }
                if (xx == 'Error') {   
                    $("#notif2").css("display", "none");
                    $("#notif4").css("display", "block");
                    btn.disabled = false;     
                }
            }
        });
    }
});
