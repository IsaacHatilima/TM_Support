$('#save').click(function(e){
    $("#cats").valid();
    if ($.trim($("#categ").val()) === "") {
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
            url: "../core/CoreCategories.php",
            data: $("form").serialize(),
            success: function(strMessage) {
                console.log(strMessage);
                var xx = strMessage;
                if (xx == 'Success') {   
                    iziToast.show({
                        title: 'Success!',
                        message: 'Category Added Successfully.',
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
                        message: 'Failed To Add Category. Please Try Again.',
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
        url: "../core/CoreCategories.php",
        data: {"deleteCate" : x},
        success: function(strMessage) {
            console.log(strMessage);
            var xx = strMessage;
            if (xx == 'Success') {   
                iziToast.show({
                    title: 'Success!',
                    message: 'Category Deleted Successfully.',
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
                    message: 'Failed To Delete Category. Please Try Again.',
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