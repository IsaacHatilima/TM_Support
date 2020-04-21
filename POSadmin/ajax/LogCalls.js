
function getDeviceSerials(event)
{
    event.preventDefault();
    var val = document.getElementById("mechtype").value;
    $("#lock-modal").css("display", "block");
    $("#loading-circle").css("display", "block");
    $.ajax({
        type: "POST",
        url: "../core/CoreLogCalls.php",
        data: { 'metype': val },
        dataType: "html",
        success: function(strMessage) {
            console.log(strMessage);
            $('#dev_serial').html(strMessage);
            $("#lock-modal").css("display", "none");
            $("#loading-circle").css("display", "none");
        }
    });
}

function getSubCate(event)
{
    event.preventDefault();
    var val = document.getElementById("cate").value;
    $("#lock-modal").css("display", "block");
    $("#loading-circle").css("display", "block");
    $.ajax({
        type: "POST",
        url: "../core/CoreLogCalls.php",
        data: { 'catego': val },
        dataType: "html",
        success: function(strMessage) {
            console.log(strMessage);
            $('#sub_cat').html(strMessage);
            $("#lock-modal").css("display", "none");
            $("#loading-circle").css("display", "none");
        }
    });
}

$('#gencall').click(function(e){
    $("#general_call").valid();
    if ($.trim($("#priority").val()) === "" || $.trim($("#mechtype").val()) === "" || $.trim($("#dev_serial").val()) === "" || $.trim($("#cate").val()) === "" || $.trim($("#sub_cat").val()) === "" || $.trim($("#fault").val()) === "" || $.trim($("#manager_name").val()) === "" || $.trim($("manager_cell").val()) === null || $.trim($("requester").val()) === null ) {
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
        $("#lock-modal").css("display", "block");
        $("#loading-circle").css("display", "block");
        $.ajax({
            type: "post",
            url: "../core/CoreLogCalls.php",
            data: $("form").serialize(),
            success: function(strMessage) {
                console.log(strMessage);
                var xx = strMessage;
                if (xx != 'Failed' || xx != 'Error') {   
                    iziToast.show({
                        title: 'Success!',
                        message: 'General Call Created Successfully.',
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
                        message: 'Failed To Create General Call. Please Try Again.',
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

// Delivery Call
function getMechants(event)
{
    event.preventDefault();
    var val = document.getElementById("delivery_mechtype").value;
    $("#lock-modal").css("display", "block");
    $("#loading-circle").css("display", "block");
    $.ajax({
        type: "POST",
        url: "../core/CoreLogCalls.php",
        data: { 'mechID': val },
        dataType: "html",
        success: function(strMessage) {
            console.log(strMessage);
            $('#mech_id').html(strMessage);
            $("#lock-modal").css("display", "none");
            $("#loading-circle").css("display", "none");
        }
    });
}

function getDevSubCate(event)
{
    event.preventDefault();
    var val = document.getElementById("delivery_cate").value;
    $("#lock-modal").css("display", "block");
    $("#loading-circle").css("display", "block");
    $.ajax({
        type: "POST",
        url: "../core/CoreLogCalls.php",
        data: { 'delivery_cate': val },
        dataType: "html",
        success: function(strMessage) {
            console.log(strMessage);
            $('#delivery_sub_cat').html(strMessage);
            $("#lock-modal").css("display", "none");
            $("#loading-circle").css("display", "none");
        }
    });
}
$('#delivery_call').click(function(e){
    $("#delivery_form_call").valid();
    if ($.trim($("#delivery_priority").val()) === "" || $.trim($("#mech_id").val()) === "" || $.trim($("#delivery_cate").val()) === "" || $.trim($("#delivery_sub_cat").val()) === "" || $.trim($("#item").val()) === "" || $.trim($("#delivery_manager_name").val()) === "" || $.trim($("delivery_manager_cell").val()) === null || $.trim($("delivery_requester").val()) === null ) {
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
        $("#lock-modal").css("display", "block");
        $("#loading-circle").css("display", "block");
        $.ajax({
            type: "post",
            url: "../core/CoreLogCalls.php",
            data: $("form").serialize(),
            success: function(strMessage) {
                console.log(strMessage);
                var xx = strMessage;
                if (xx != 'Failed' || xx != 'Error') {   
                    iziToast.show({
                        title: 'Success!',
                        message: 'Delivery Call Created Successfully.',
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
                        message: 'Failed To Create Delivery Call. Please Try Again.',
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