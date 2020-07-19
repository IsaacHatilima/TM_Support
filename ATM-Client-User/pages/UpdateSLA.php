<!DOCTYPE html>
<html lang="en">
<head>
	<?php include '../includes/header.php'; ?>
    <script type="text/javascript" src="../../assets/js/pages/form_select2.js"></script>
    <script type="text/javascript" src="../../assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/selects/select2.min.js"></script>
</head>

<body class="navbar-bottom navbar-top">
	<?php include '../includes/topnav.php'; ?>

    <div id="lock-modal"></div>
    <div id="loading-circle"></div>
	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h6 class="panel-title">Add SLA Times</h6>
                            </div>
                            <?php
                                // $sla_id = $_GET['sla_id'];
                                // list($sla_id, $enc_iv) = explode("::", $sla_id);  
                                // $cipher_method = 'aes-128-ctr';
                                // $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
                                // $token = openssl_decrypt($sla_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
                                // $sla_id = $token;
                            ?>

                            <div class="panel-body">
                                <form class="form-horizontal" id="slaForm" action="" method="POST">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Client:<span class="text-danger">*</span> </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" type="text" name="client_name" id="client_name" readonly>
                                                        <input class="form-control" type="text" name="slas_id" id="slas_id" value="<?php echo $_GET['sla_id']; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <legend class="text-bold">Week Days (Monday to Friday)</legend>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Start:<span class="text-danger">*</span> </label>
                                                    <div class="col-md-8">
                                                    <input class="form-control" type="time" name="start_time" id="start_time" required="required">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">End:<span class="text-danger">*</span> </label>
                                                    <div class="col-md-8">
                                                    <input class="form-control" type="time" name="end_time" id="end_time" required="required">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                       
                                    </div>
                                    <legend class="text-bold">Weekends and Holidays</legend>
                                    <div class="form-group">
                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Start:<span class="text-danger">*</span> </label>
                                                    <div class="col-md-8">
                                                    <input class="form-control" type="time" name="wik_start_time" id="wik_start_time" required="required">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">End:<span class="text-danger">*</span> </label>
                                                    <div class="col-md-8">
                                                    <input class="form-control" type="time" name="wik_end_time" id="wik_end_time" required="required">
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        
                                    </div>

                                    <div class="text-right">
                                        <button type="button" id='update' class="btn btn-primary">Save <i class="icon-floppy-disk position-right"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
			</div>
		</div>
	</div>
    <script src="../ajax/SLA.js"></script>
    <script>
        $(document).ready(function(){
            event.preventDefault();
            $("#lock-modal").css("display", "block");
            $("#loading-circle").css("display", "block");
            var ex = document.getElementById("slas_id").value;
            $.ajax({
                type: "post",
                url: "../core/SLATiming.php",
                data: {"sla_id" : ex},
                success: function(strMessage) {
                    console.log(strMessage);
                    var xx = strMessage;
                    if (xx != 'Nothing' || xx != 'Error') {
                        var obj = JSON.parse(strMessage); 
                        $('#client_name').val(obj.client_name); 
                        $('#start_time').val(obj.start_time); 
                        $('#end_time').val(obj.end_time);
                        $('#wik_start_time').val(obj.wik_start_time);
                        $('#wik_end_time').val(obj.wik_end_time); 

                        $("#lock-modal").css("display", "none");
                        $("#loading-circle").css("display", "none");
                    }
                    if (xx == 'Nothing') {    
                        iziToast.show({
                            title: 'Warning!',
                            message: 'This Ticket Does No Exist.',
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
        });

    </script>
</body>
</html>
