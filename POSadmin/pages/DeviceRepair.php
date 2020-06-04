<!DOCTYPE html>
<html lang="en">
<head>
	<?php include '../includes/header.php'; ?>
	<script type="text/javascript" src="../../assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="../../assets/js/pages/form_select2.js"></script>
	<script type="text/javascript" src="../../assets/js/pages/datatables_extension_buttons_html5.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/tables/datatables/extensions/responsive.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
	<script type="text/javascript" src="../../assets/js/pages/datatables_responsive.js"></script>
	<script type="text/javascript" src="../../assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
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
                            <div class="panel panel-flat">
                                <div class="modal-header">
                                    <h5 class="modal-title">Device Details</h5>
                                </div>
                                <div class="panel-body">
                                    <form class="form-horizontal" id="devrepair" action="" method="POST">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Reference Number: </label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="ref_num" id="ref_num" readonly class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Repair Status: </label>
                                                    <div class="col-md-8">
                                                        <input type="text" id="state" readonly class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Device Type: </label>
                                                    <div class="col-md-8">
                                                        <input type="text" id="devtype" readonly class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Device Serial: </label>
                                                    <div class="col-md-8">
                                                        <input type="text" id="dev_serial" readonly class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">PTID: </label>
                                                    <div class="col-md-8">
                                                        <input type="text" id="ptid" readonly class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Warranty Sticker: </label>
                                                    <div class="col-md-8">
                                                        <input type="text" id="warrant" readonly class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Fault on Screen: </label>
                                                    <div class="col-md-8">
                                                        <input type="text" id="fault" readonly class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">General Problem: </label>
                                                    <div class="col-md-8">
                                                        <textarea readonly rows="5" cols="5" id="gen_prob" class="form-control" placeholder="General Problem"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Parts Used:<span class="text-danger">*</span> </label>
                                                    <div class="col-md-8">
                                                    <textarea rows="5" name="parts_used" id="parts_used" cols="5" class="form-control" required="required" placeholder="State Parts Used"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">EOS Reloaded: </label>
                                                    <div class="col-md-8">
                                                        <select data-placeholder="EOS Reloaded" class="select-icons" name="eos_reload" name="eos_reload">
                                                        <option></option>
                                                            <optgroup label="EOS Reload Option">
                                                                <option value="Yes" data-icon="checkmark">Yes</option>
                                                                <option value="No" data-icon="cross">No</option>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Final Test:<span class="text-danger">*</span> </label>
                                                    <div class="col-md-8">
                                                    <input type="text" id="test_results" name="test_results" class="form-control" required="required" placeholder="Enter Final Test Comment Here">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Comment: </label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="comment" placeholder="Enter Comment Here">
                                                        <input type="hidden" id="repaired_id" value="<?php echo $_GET['id']; ?>" class="form-control" name="repaired_id" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Repaired By:<span class="text-danger">*</span> </label>
                                                    <div class="col-md-8">
                                                        <select data-placeholder="Select Engineer" class="select-search" name="fixed_by" id="fixed_by" required="required">
                                                        <option></option>
                                                            <optgroup label="Engineers">
                                                            <?php
                                                                $sql = "SELECT * FROM engineers;";
                                                                $stmt = $object->connect()->prepare($sql);
                                                                $stmt->execute();
                                                                while ($rows = $stmt->fetch())
                                                                {
                                                                    $id = $rows['engineer_id'];

                                                                    $token = $id;

                                                                    $cipher_method = 'aes-128-ctr';
                                                                    $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);  
                                                                    $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));  
                                                                    $crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);

                                                                    echo '<option value="'.$crypted_token.'">'.$rows['engineer_first_name'].' '.$rows['engineer_last_name'].'</option>';
                                                                }
                                                            ?>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" id="update" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
						</div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
			</div>
		</div>
	</div>
	<div id="lock-modal"></div>
    <div id="loading-circle"></div>
	<script src="../ajax/DeviceRepair.js"></script>
	<script>
        $(document).ready( function (e) {
            var repairs_id = document.getElementById('repaired_id').value
            $("#lock-modal").css("display", "block");
            $("#loading-circle").css("display", "block");
            $.ajax({
                type: "POST",
                url: "../core/CoreDeviceRepair.php",
                data: { "repairs_id" : repairs_id },
                success: function(strMessage) {
                    console.log(strMessage);
                    var xx = strMessage;
                    if (xx != 'Error') {   
                        var obj = JSON.parse(strMessage);
                        $('#ref_num').val(obj.ref_numb);
                        $('#state').val(obj.status);
                        $('#devtype').val(obj.dev_type);
                        $('#dev_serial').val(obj.serial);
                        $('#ptid').val(obj.ptid);
                        $('#warrant').val(obj.warrant_sticker);
                        $('#fault').val(obj.fault_on_screen);
                        $('#gen_prob').val(obj.general_problem);  
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
