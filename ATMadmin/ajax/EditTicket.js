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
            url: "../core/CoreTicketEdit.php",
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
                    $('#priority').prepend('<option value="'+obj.priority+'" selected>'+obj.priority+'</option>');
                    $('#cate').prepend('<option value="'+obj.category_id_fk+'" selected>'+obj.cate+'</option>');
                    getSubCate(event);
                    $('#sub_cat').prepend('<option value="'+obj.sub_category_id_fk+'" selected>'+obj.sub_category+'</option>');
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

function getSubCate(event)
{
    event.preventDefault();
    var val = document.getElementById("cate").value;
    $("#lock-modal").css("display", "block");
    $("#loading-circle").css("display", "block");
    $.ajax({
        type: "POST",
        url: "../core/CoreTicketEdit.php",
        data: { 'catego': val },
        dataType: "html",
        success: function(strMessage) {
            console.log(strMessage);
            $('#sub_cat').append(strMessage);
            $("#lock-modal").css("display", "none");
            $("#loading-circle").css("display", "none");
        }
    });
}

$('#edit_ticket').click(function(e){
    if ($.trim($("#ticket_number").val()) === "" || $.trim($("#priority").val()) === "" || $.trim($("#cate").val()) === "" || $.trim($("#sub_cat").val()) === "" || $.trim($("#fault").val()) === "" ) {
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
        $(this).find('#edit_ticket').attr('disabled', 'disabled');
        $("#lock-modal").css("display", "block");
        $("#loading-circle").css("display", "block");
        $.ajax({
            type: "post",
            url: "../core/CoreTicketEdit.php",
            data: $("form").serialize(),
            cache: false,
            processData:false,
            success: function(strMessage) {
                console.log(strMessage);
                $('#edit_ticket').removeAttr('disabled');
                var xx = strMessage;
                if (xx == 'Success') {
                    iziToast.show({
                        title: 'Success!',
                        message: 'Ticket Updated Successfully.',
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
                        message: 'Failed To Update Ticket. Please try again.',
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

function getSubCates(event)
{
    event.preventDefault();
    var val = document.getElementById("cate").value;
    $("#lock-modal").css("display", "block");
    $("#loading-circle").css("display", "block");
    $.ajax({
        type: "POST",
        url: "../core/CoreTicketEdit.php",
        data: { 'categ': val },
        dataType: "html",
        success: function(strMessage) {
            console.log(strMessage);
            $('#sub_cat').html(strMessage);
            $("#lock-modal").css("display", "none");
            $("#loading-circle").css("display", "none");
        }
    });
}