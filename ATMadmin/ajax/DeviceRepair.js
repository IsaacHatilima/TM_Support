function getMechID(event)
{
    event.preventDefault();
    var val = document.getElementById("mechtype").value;
    $("#lock-modal").css("display", "block");
    $("#loading-circle").css("display", "block");
    $.ajax({
        type: "POST",
        url: "../core/CoreDeviceInfo.php",
        data: { 'metype': val },
        dataType: "html",
        success: function(strMessage) {
            console.log(strMessage);
            $('#mechID').html(strMessage);
            $("#lock-modal").css("display", "none");
            $("#loading-circle").css("display", "none");
        }
    });
}

function modal(x)
{
    // event.preventDefault();
    $("#lock-modal").css("display", "block");
    $("#loading-circle").css("display", "block");
    var val = document.getElementsByName("ref_num").value;
    alert(x);
}

// $('#save2').click(function(e){
//     $("#form2").valid();
//     if ($.trim($("#parts").val()) === "" || $.trim($("#test_res").val()) === "") {
//         iziToast.show({
//             title: 'Warning!',
//             message: 'All Fields With A * Are Required.',
//             color: 'yellow',
//             position: 'topRight',
//             icon: 'fa fa-check',
//             timeout: 2000
//         }); 
//         return false;
//     }
//     else{
//         e.preventDefault();
//         $("#lock-modal").css("display", "block");
//         $("#loading-circle").css("display", "block");
//         $.ajax({
//             type: "post",
//             url: "../core/CoreDeviceRepair.php",
//             data: $("form").serialize(),
//             success: function(strMessage) {
//                 console.log(strMessage);
//                 var xx = strMessage;
//                 if (xx == 'Success') {   
//                     iziToast.show({
//                         title: 'Success!',
//                         message: 'Device Added Successfully.',
//                         color: 'green',
//                         position: 'topRight',
//                         icon: 'fa fa-check',
//                         timeout: 2000
//                     });  
//                     setTimeout(function(){
//                         window.location.reload(1);
//                     }, 2500);  
//                 }
//                 if (xx == 'Failed') {    
//                     iziToast.show({
//                         title: 'Warning!',
//                         message: 'Failed To Add Device. Please Try Again.',
//                         color: 'yello',
//                         position: 'topRight',
//                         icon: 'fa fa-check',
//                         timeout: 2000
//                     });  
//                     $("#lock-modal").css("display", "none");
//                     $("#loading-circle").css("display", "none");  
//                 }
//                 if (xx == 'Error') {    
//                     iziToast.show({
//                         title: 'Error!',
//                         message: 'An Error Occured. Please Try Again.',
//                         color: 'red',
//                         position: 'topRight',
//                         icon: 'fa fa-check',
//                         timeout: 2000
//                     });   
//                     $("#lock-modal").css("display", "none");
//                     $("#loading-circle").css("display", "none"); 
//                 }
//             }
//         });
//     }
// });

$('#save').click(function(e){
    $("#repair_device").valid();
    if ($.trim($("#devtype").val()) === "" || $.trim($("#device_serial").val()) === "" || $.trim($("#warranty").val()) === "" || $.trim($("#gen_prob").val()) === "") {
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
            url: "../core/CoreDeviceRepair.php",
            data: $("form").serialize(),
            success: function(strMessage) {
                console.log(strMessage);
                var xx = strMessage;
                if (xx == 'Success') {   
                    iziToast.show({
                        title: 'Success!',
                        message: 'Device Added Successfully.',
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
                        message: 'Failed To Add Device. Please Try Again.',
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
    $("#devrepair").valid();
    var fixed_by = document.getElementById('fixed_by').value;
    var test_results = document.getElementById('test_results').value;
    var parts_used = document.getElementById('parts_used').value;
    if (fixed_by === "" || test_results === "" || parts_used === "" ){
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
    else
    {
        e.preventDefault();
        $("#lock-modal").css("display", "block");
        $("#loading-circle").css("display", "block");
        $.ajax({
            type: "POST",
            url: "../core/CoreDeviceRepair.php",
            data: $("form").serialize(),
            success: function(strMessage) {
                console.log(strMessage);
                var xx = strMessage;
                if (xx == 'Success') {   
                    iziToast.show({
                        title: 'Success!',
                        message: 'Device Repair Updated Successfully.',
                        color: 'green',
                        position: 'topRight',
                        icon: 'fa fa-check',
                        timeout: 2000
                    });  
                    setTimeout(function(){
                        window.location.replace("RepairedDevices");
                    }, 2500);  
                }
                if (xx == 'Failed') {    
                    iziToast.show({
                        title: 'Warning!',
                        message: 'Failed To Update Device Repair. Please Try Again.',
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
        url: "../core/CoreDeviceInfo.php",
        data: {"deletedev" : x},
        success: function(strMessage) {
            console.log(strMessage);
            var xx = strMessage;
            if (xx == 'Success') {   
                iziToast.show({
                    title: 'Success!',
                    message: 'Device Deleted Successfully.',
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
                    message: 'Failed To Delete Device. Please Try Again.',
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