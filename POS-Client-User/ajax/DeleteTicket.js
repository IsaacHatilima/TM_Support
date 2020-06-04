$('#search').click(function(e){
    //$("#benks").valid();
    if ($.trim($("#ticket_number").val()) === "") {
        iziToast.show({
            title: 'Warning!',
            message: 'Ticket Number Is Required.',
            color: 'yellow',
            position: 'topRight',
            icon: 'fa fa-check',
            timeout: 2000
        }); 
        return false;
    }
    else{
        e.preventDefault();
        $(this).find('#search').attr('disabled', 'disabled');
        $("#lock-modal").css("display", "block");
        $("#loading-circle").css("display", "block");
        $.ajax({
            type: "post",
            url: "../core/DeleteTicketCore.php",
            data: $("form").serialize(),
            cache: false,
            processData:false,
            success: function(strMessage) {
                console.log(strMessage);
                $('#search').removeAttr('disabled');
                var xx = strMessage;
                if (xx === 'Nothing') {  
                    $("#lock-modal").css("display", "none");
                    $("#loading-circle").css("display", "none");  
                    iziToast.show({
                        title: 'Warning!',
                        message: 'No Record With This Ticket Number.',
                        color: 'yellow',
                        position: 'topRight',
                        icon: 'fa fa-check',
                        timeout: 2000
                    });    
                }
                if (xx !== 'Nothing' && xx !== 'Error') {
                    $("#lock-modal").css("display", "none");
                    $("#loading-circle").css("display", "none");
                    var obj = JSON.parse(strMessage);
                    $('#priority').val(obj.priority);
                    $('#cate').val(obj.cate);
                    $('#sub_cat').val(obj.sub_category);
                    $('#dev_serial').val(obj.call_device_serial);
                    $('#fault').val(obj.fault_details);
                    $('#manager_name').val(obj.managers_name);
                    $('#manager_cell').val(obj.managers_cell); 
                    $('#requester').val(obj.names); 
                    $('#mech_name').val(obj.mech_name); 
                    $('#mech_id').val(obj.mech_id); 
                }
                if (xx === 'Error') {  
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

$('#delete_ticket').click(function(e){
    if ($.trim($("#ticket_number").val()) === "") {
        iziToast.show({
            title: 'Warning!',
            message: 'Ticket Number Required.',
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
            url: "../core/DeleteTicketCore.php",
            data: $("form").serialize(),
            cache: false,
            processData:false,
            success: function(strMessage) {
                console.log(strMessage);
                $('#delete_ticket').removeAttr('disabled');
                var xx = strMessage;
                if (xx == 'Success') {
                    iziToast.show({
                        title: 'Success!',
                        message: 'Ticket Deleted Successfully.',
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
                        message: 'Failed To Delete Ticket. Please try again.',
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