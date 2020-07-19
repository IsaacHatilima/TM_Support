function getATMName(event)
{
    event.preventDefault();
    var val = document.getElementById("atm_site").value;
    $("#lock-modal").css("display", "block");
    $("#loading-circle").css("display", "block");
    $.ajax({
        type: "POST",
        url: "../core/AcceptCallCore.php",
        data: { 'atms_name': val },
        dataType: "html",
        success: function(strMessage) {
            //console.log(strMessage);
            $('#atm_name').html(strMessage);
            $("#lock-modal").css("display", "none");
            $("#loading-circle").css("display", "none");
        }
    });
}

function getSubCate(event)
{
    event.preventDefault();
    var val = document.getElementById("category").value;
    $("#lock-modal").css("display", "block");
    $("#loading-circle").css("display", "block");
    $.ajax({
        type: "POST",
        url: "../core/AcceptCallCore.php",
        data: { 'cate_id': val },
        dataType: "html",
        success: function(strMessage) {
            console.log(strMessage);
            $('#sub_category').html(strMessage);
            $("#lock-modal").css("display", "none");
            $("#loading-circle").css("display", "none");
        }
    });
}

$('#create_ticket').click(function(e){
    if ($.trim($("#atm_site").val()) === "" || $.trim($("#atm_name").val()) === "" || $.trim($("#category").val()) === "" || $.trim($("#sub_category").val()) === "" || $.trim($("#fault").val()) === "" || $.trim($("#custodian_name").val()) === "" || $.trim($("#custodian_number").val()) === "" ) {
        iziToast.show({
            title: 'Warning!',
            message: 'All Fields Required.',
            color: 'yellow',
            position: 'topRight',
            icon: 'fa fa-check',
            timeout: 2000
        }); 
        return false;
    }
    else{
        e.preventDefault();
        $(this).find('#create_ticket').attr('disabled', 'disabled');
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
                $('#create_ticket').removeAttr('disabled');
                var xx = strMessage;
                if (xx != 'Failed' || xx != 'Error') {
                    iziToast.show({
                        title: 'Success!',
                        message: 'Ticket Created Successfully.',
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
                        message: 'Failed To Create Ticket. Please try again.',
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