$('#save').click(function(e){
    $("#mechs").valid();
    if ($.trim($("#mechtype").val()) === "" || $.trim($("#mechname").val()) === "" || $.trim($("#mechID").val()) === "" || $.trim($("#prov").val()) === "" || $.trim($("#town").val()) === "") {
        iziToast.show({
            title: 'Warning!',
            message: 'All Fields Are Required.',
            color: 'yellow',
            position: 'topRight',
            icon: 'fa fa-check',
            timeout: 2000
        }); 
        return false;
    }
    else{
        e.preventDefault();
        $("#lock-modal").css("display", "block");
        $("#loading-circle").css("display", "block");
        $.ajax({
            type: "post",
            url: "../core/Mech.php",
            data: $("form").serialize(),
            success: function(strMessage) {
                console.log(strMessage);
                var xx = strMessage;
                if (xx == 'Success') {   
                    iziToast.show({
                        title: 'Success!',
                        message: 'Mechant Added Successfully.',
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
                        message: 'Failed To Add Mechant. Please Try Again.',
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
                        message: 'An Error Occured. Please Try Again.',
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

$('#update').click(function(e){
    $("#updatemech").valid();
    if ($.trim($("mechtype2").val()) === null || $.trim($("mechname2").val()) === null || $.trim($("mechID2").val()) === null || $.trim($("prov2").val()) === null || $.trim($("town2").val()) === null) {
        iziToast.show({
            title: 'Warning!',
            message: 'All Fields Are Required.',
            color: 'yellow',
            position: 'topRight',
            icon: 'fa fa-check',
            timeout: 2000
        }); 
        return false;
    }
    else
    {
        e.preventDefault();
        var ID = $(this).attr('data-value');
        $("#lock-modal").css("display", "block");
        $("#loading-circle").css("display", "block");
        $.ajax({
            type: "post",
            url: "../core/Mech.php",
            data: $("form").serialize(),
            success: function(strMessage) {
                console.log(strMessage);
                var xx = strMessage;
                if (xx == 'Success') {   
                    iziToast.show({
                        title: 'Success!',
                        message: 'Mechant Updated Successfully.',
                        color: 'green',
                        position: 'topRight',
                        icon: 'fa fa-check',
                        timeout: 2000
                    });  
                    setTimeout(function(){
                        window.location.replace("Mechants");
                    }, 2500);  
                }
                if (xx == 'Failed') {    
                    iziToast.show({
                        title: 'Warning!',
                        message: 'Failed To Update Mechant. Please Try Again.',
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
                        message: 'An Error Occured. Please Try Again.',
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
        url: "../core/Mech.php",
        data: {"deleteMech" : x},
        success: function(strMessage) {
            console.log(strMessage);
            var xx = strMessage;
            if (xx == 'Success') {   
                iziToast.show({
                    title: 'Success!',
                    message: 'Mechant Deleted Successfully.',
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
                    message: 'Failed To Delete Mechant. Please Try Again.',
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