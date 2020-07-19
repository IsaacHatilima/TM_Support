$('#saver').click(function(e){
    $("#benks").valid();
    if ($.trim($("#bankName").val()) === "") {
        iziToast.show({
            title: 'Warning!',
            message: 'All Fields With A * Are Required.',
            color: 'yellow',
            position: 'topRight',
            icon: 'fa fa-check',
            timeout: 2000
        }); 
        return false;
    }
    else{
        e.preventDefault();
        $(this).find('#saver').attr('disabled', 'disabled');
        $("#lock-modal").css("display", "block");
        $("#loading-circle").css("display", "block");
        $.ajax({
            type: "post",
            url: "../core/CoreAddClient.php",
            data: $("form").serialize(),
            cache: false,
            processData:false,
            success: function(strMessage) {
                console.log(strMessage);
                $('#saver').removeAttr('disabled');
                var xx = strMessage;
                if (xx == 'Success') {
                    iziToast.show({
                        title: 'Success!',
                        message: 'Client added successfully.',
                        color: 'green',
                        position: 'topRight',
                        icon: 'fa fa-check',
                        timeout: 2000
                    });    
                    setTimeout(function(){
                        window.location.reload(1);
                    }, 2500); 
                }
                if (xx == 'Failed') {  
                    $("#lock-modal").css("display", "none");
                    $("#loading-circle").css("display", "none");  
                    iziToast.show({
                        title: 'Warning!',
                        message: 'Failed to add Client. Please try again.',
                        color: 'yello',
                        position: 'topRight',
                        icon: 'fa fa-check',
                        timeout: 2000
                    });    
                }
                if (xx == 'Error') {  
                    $("#lock-modal").css("display", "none");
                    $("#loading-circle").css("display", "none");  
                    iziToast.show({
                        title: 'Error!',
                        message: 'An error occured. Please try again.',
                        color: 'red',
                        position: 'topRight',
                        icon: 'fa fa-check',
                        timeout: 2000
                    });    
                }
            }
        });
    }
});

$('#updatebtn').click(function(e){
    $("#benks").valid();
    if ($.trim($("#bankName").val()) === "") {
        iziToast.show({
            title: 'Warning!',
            message: 'All Fields With A * Are Required.',
            color: 'yellow',
            position: 'topRight',
            icon: 'fa fa-check',
            timeout: 2000
        }); 
        return false;
    }
    else{
        e.preventDefault();
        $(this).find('#updatebtn').attr('disabled', 'disabled');
        $("#lock-modal").css("display", "block");
        $("#loading-circle").css("display", "block");
        $.ajax({
            type: "post",
            url: "../core/CoreAddClient.php",
            data: $("form").serialize(),
            cache: false,
            processData:false,
            success: function(strMessage) {
                console.log(strMessage);
                $('#updatebtn').removeAttr('disabled');
                var xx = strMessage;
                if (xx == 'Success') {   
                    iziToast.show({
                        title: 'Success!',
                        message: 'Client updated successfully.',
                        color: 'green',
                        position: 'topRight',
                        icon: 'fa fa-check',
                        timeout: 2000
                    });   
                    setTimeout(function(){
                        window.location.href = "ViewClient";
                    }, 2500); 
                }
                if (xx == 'Failed') {    
                    iziToast.show({
                        title: 'Warning!',
                        message: 'Failed to Update Client. Please try again.',
                        color: 'yello',
                        position: 'topRight',
                        icon: 'fa fa-check',
                        timeout: 2000
                    });    
                    $("#lock-modal").css("display", "none");
                    $("#loading-circle").css("display", "none");
                }
                if (xx == 'Error') {    
                    iziToast.show({
                        title: 'Error!',
                        message: 'An error occured. Please try again.',
                        color: 'red',
                        position: 'topRight',
                        icon: 'fa fa-check',
                        timeout: 2000
                    });    
                    $("#lock-modal").css("display", "none");
                    $("#loading-circle").css("display", "none");
                }
            }
        });
    }
});

function Deletes(x)
{
    event.preventDefault();
    $("#lock-modal").css("display", "block");
    $("#loading-circle").css("display", "block");
    $.ajax({
        type: "post",
        url: "../core/CoreAddClient.php",
        data: {"deleteBank" : x},
        success: function(strMessage) {
            console.log(strMessage);
            var xx = strMessage;
            if (xx == 'Success') {   
                iziToast.show({
                    title: 'Success!',
                    message: 'Client Deleted Successfully.',
                    color: 'green',
                    position: 'topRight',
                    icon: 'fa fa-check',
                    timeout: 2000
                });   
                setTimeout(function(){
                    window.location.reload(1);
                }, 2500);  
            }
            if (xx == 'Failed') {    
                iziToast.show({
                    title: 'Warning!',
                    message: 'Failed To Delete Client. Please Try Again.',
                    color: 'yello',
                    position: 'topRight',
                    icon: 'fa fa-check',
                    timeout: 2000
                });  
                $("#lock-modal").css("display", "block");
                $("#loading-circle").css("display", "block");  
            }
            if (xx == 'Error') {    
                iziToast.show({
                    title: 'Error!',
                    message: 'An Error Occured. Please Try Again.',
                    color: 'red',
                    position: 'topRight',
                    icon: 'fa fa-check',
                    timeout: 2000
                });   
                $("#lock-modal").css("display", "block");
                $("#loading-circle").css("display", "block"); 
            }
        }
    });
}