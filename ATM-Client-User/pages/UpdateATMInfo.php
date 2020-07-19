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
	<div class="page-container">
    <div id="lock-modal"></div>
    <div id="loading-circle"></div>
		<div class="page-content">
			<div class="content-wrapper">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 >Update ATM Info</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <?php

                                        $IDs = $_GET['id'];
                                        list($IDs, $enc_iv) = explode("::", $IDs);  
                                        $cipher_method = 'aes-128-ctr';
                                        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
                                        $token = openssl_decrypt($IDs, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
                                        $atmID = $token;

                                        $sql = "SELECT * FROM atm_details, clients WHERE client_id = client_id_fk AND atm_id = ?;";
                                        $stmt = $object->connect()->prepare($sql);
                                        $stmt->bindvalue(1,$atmID);
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
                                                        <label class="col-md-4 control-label text-right">Client: </label>
                                                        <div class="col-md-8">
                                                        <input type="text" class="form-control" value="<?php echo $rows['client_name'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">ATM Name:<span class="text-danger">*</span> </label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" value="<?php echo $rows['atm_name'] ?>" name="atm_name2" id="atm_name2" required = "required">
                                                            <input type="hidden" name="atmID2" value="<?php echo $_GET['id'] ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">Model:<span class="text-danger">*</span> </label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="model2" id="model2" value="<?php echo $rows['atm_model'] ?>" required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">ATM Type:<span class="text-danger">*</span> </label>
                                                        <div class="col-md-8">
                                                        <input type="text" class="form-control" value="<?php echo $rows['atm_type'] ?>" name="atm_type2" id="atm_type2" required = "required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <label class="col-md-4 control-label text-right">Site:<span class="text-danger">*</span> </label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" value="<?php echo $rows['atm_site'] ?>" name="site2" id="site2" required = "required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Province:<span class="text-danger">*</span> </label>
                                                    <div class="col-md-8">
                                                    <select data-placeholder="Select Province" name="prov2" id="prov2" class="select-search" required="required">
                                                        <option></option>
                                                        <optgroup label="Available Provinces">
                                                            <option value="<?php echo $rows['province'] ?>" selected><?php echo $rows['province'] ?></option>
                                                            <option value="Central">Central</option>
                                                            <option value="Copperbelt">Copperbelt</option>
                                                            <option value="Eastern">Eastern</option>
                                                            <option value="Luapula">Luapula</option>
                                                            <option value="Lusaka">Lusaka</option>
                                                            <option value="Muchinga">Muchinga</option>
                                                            <option value="Northern">Northern</option>
                                                            <option value="North-Westen">North-Westen</option>
                                                            <option value="Southern">Southern</option>
                                                            <option value="Western">Western</option>
                                                        </optgroup>
                                                    </select>
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

	<script src="../ajax/DeviceInfo.js"></script>

</body>
</html>
