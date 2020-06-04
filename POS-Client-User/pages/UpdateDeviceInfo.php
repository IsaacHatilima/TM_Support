<!DOCTYPE html>
<html lang="en">
<head>
	<?php include '../includes/header.php'; ?>
	<script type="text/javascript" src="../../assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="../../assets/js/pages/form_select2.js"></script>
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
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 >Update POS Device Info</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <?php

                                        $IDs = $_GET['id'];
                                        list($IDs, $enc_iv) = explode("::", $IDs);  
                                        $cipher_method = 'aes-128-ctr';
                                        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
                                        $token = openssl_decrypt($IDs, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
                                        $mechID = $token;

                                        $sql = "SELECT * FROM mechants,device_info WHERE mechant_log_id = mechant_log_id_fk AND device_id = ?;";
                                        $stmt = $object->connect()->prepare($sql);
                                        $stmt->bindvalue(1,$mechID);
                                        $stmt->execute();
                                        $rows = $stmt->fetch();
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel-body">
                                        <form action="#" method="POST" id="updatedevice" class="form-horizontal">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">Mechant Type: </label>
                                                        <div class="col-md-8">
                                                        <input type="text" class="form-control" value="<?php echo $rows['mechant_type'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">Mechant Name: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" value="<?php echo $rows['mechant_name'] ?>" readonly>
                                                            <input type="hidden" name="devID" value="<?php echo $_GET['id'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">Mechant ID:<span class="text-danger">*</span> </label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="mechID2" id="mechID2" value="<?php echo $rows['mechant_id'] ?>" required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">Province: </label>
                                                        <div class="col-md-8">
                                                        <input type="text" class="form-control" value="<?php echo $rows['mechant_province'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">Mechant Site: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" value="<?php echo $rows['mechant_town'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">Device Type:<span class="text-danger">*</span> </label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="devtype2" id="devtype2" value="<?php echo $rows['device_type'] ?>" required = "required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">Terminal ID:<span class="text-danger">*</span> </label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="terminaID2" id="terminaID2" value="<?php echo $rows['terminal_id'] ?>" required = "required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">Device Serial:<span class="text-danger">*</span> </label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="device_serial2" id="device_serial2" value="<?php echo $rows['device_serial'] ?>" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">Base Serial: </label>
                                                        <div class="col-md-8">
                                                        <input type="text" name="base_serial2" class="form-control"  value="<?php echo $rows['base_serial'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">MTN SIM Serial: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="mtn_sim_serial2" value="<?php echo $rows['mtn_sim_serial'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">Airtel SIM Serial: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="airtel_sim_serial2" value="<?php echo $rows['airtel_sim_serial'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">IP Address:<span class="text-danger">*</span> </label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="ip_address2" id="ip_address2" value="<?php echo $rows['ip_address'] ?>" required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">FNB Asset Code:<span class="text-danger">*</span> </label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="asset_code2" id="asset_code2" value="<?php echo $rows['fnb_asset_code'] ?>" required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">Installation Date:<span class="text-danger">*</span> </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="installation_date2" id="installation_date2" class="form-control" data-mask="99/99/9999" value="<?php echo $rows['installation_date'] ?>" required="required">
                                                            <span class="help-block">99/99/9999</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <a href="Mechants" class="btn btn-default">Cancel</a>
                                                <button type="button" id="update" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-3">
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
	<script src="../ajax/DeviceInfo.js"></script>

</body>
</html>
