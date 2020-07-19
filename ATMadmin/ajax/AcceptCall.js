$('#accept_ticket').click(function(e){
    if ($.trim($("#engineer").val()) === "") {
        iziToast.show({
            title: 'Warning!',
            message: 'Engineer is Required.',
            color: 'yellow',
            position: 'topRight',
            icon: 'fa fa-check',
            timeout: 2000
        }); 
        return false;
    }
    else{
        e.preventDefault();
        $(this).find('#accept_ticket').attr('disabled', 'disabled');
        $("#lock-modal").css("display", "block");
        $("#loading-circle").css("display", "block");
        $.ajax({
            type: "post",
            url: "../core/AcceptCallCore.php",
            data: $("form").serialize(),
            cache: false,
            processData:false,
            success: function(strMessage) {
                console.log(strMessage);
                $('#accept_ticket').removeAttr('disabled');
                var xx = strMessage;
                if (xx != 'Failed' || xx != 'Error') {
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

$('#cust_state_btn').click(function(e){
    if ($.trim($("#custodianz").val()) === "") {
        iziToast.show({
            title: 'Warning!',
            message: 'Custodian Status Is Required.',
            color: 'yellow',
            position: 'topRight',
            icon: 'fa fa-check',
            timeout: 2000
        }); 
        return false;
    }
    else{
        var cus = document.getElementById("custodianz").value;
        var tik_id = document.getElementById("ticket_number").value;
        e.preventDefault();
        $("#lock-modal").css("display", "block");
        $("#loading-circle").css("display", "block");
        $.ajax({
            type: "post",
            url: "../core/AcceptCallCore.php",
            data: {"custo_ste" : cus, "tik_id" : tik_id},
            // cache: false,
            // processData:false,
            success: function(strMessage) {
                console.log(strMessage);
                var xx = strMessage;
                if (xx == 'Worked') {
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

$('#reasonDelayed').click(function(e){
    if ($.trim($("#delay_reson").val()) === "") {
        iziToast.show({
            title: 'Warning!',
            message: 'Reson For Delay Is Required.',
            color: 'yellow',
            position: 'topRight',
            icon: 'fa fa-check',
            timeout: 2000
        }); 
        return false;
    }
    else{
        var cus = document.getElementById("delay_reson").value;
        var tik_id = document.getElementById("ticket_number").value;
        e.preventDefault();
        $("#lock-modal").css("display", "block");
        $("#loading-circle").css("display", "block");
        $.ajax({
            type: "post",
            url: "../core/AcceptCallCore.php",
            data: {"Delays" : cus, "tik_id" : tik_id},
            // cache: false,
            // processData:false,
            success: function(strMessage) {
                console.log(strMessage);
                var xx = strMessage;
                if (xx == 'Worked') {
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