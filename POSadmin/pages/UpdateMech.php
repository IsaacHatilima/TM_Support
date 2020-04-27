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
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-6">
								<h5 >Update Mechant</h5>
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

                                $sql = "SELECT * FROM mechants WHERE mechant_log_id = ?;";
                                $stmt = $object->connect()->prepare($sql);
                                $stmt->bindvalue(1,$mechID);
                                $stmt->execute();
                                $rows = $stmt->fetch();
                            ?>
                        </div>
                        <div class="col-md-6">
                            <div class="panel-body">
			                	<form action="#" method="POST" id="updatemech" class="form-horizontal">
                                    <div class="form-group">
										<div class="col-md-12">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Mechant Type:<span class="text-danger">*</span> </label>
                                                <div class="col-md-8">
                                                <select data-placeholder="Select Mechant Type" name="mechtype2" id="mechtype2" class="select-search" required="required">
                                                <option value="<?php echo $rows['mechant_type'] ?>" selected = "selected"><?php echo $rows['mechant_type']?></option>
                                                    <optgroup label="Available Mechant Types">
                                                        <option value="Retail">Retail</option>
                                                        <option value="Forecourt">Forecourt</option>
                                                    </optgroup>
                                                </select>
                                                </div>
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
										<div class="col-md-12">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Mechant Name:<span class="text-danger">*</span> </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="mechname2" id="mechname2" value="<?php echo $rows['mechant_name'] ?>" required="required">
                                                    <input type="hidden" name="MeachantID" value="<?php echo $_GET['id'] ?>">
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
                                                <label class="col-md-4 control-label text-right">Province:<span class="text-danger">*</span> </label>
                                                <div class="col-md-8">
                                                <select data-placeholder="Select Province" name="prov2" id="prov2" class="select-search" required="required">
                                                    <option value="<?php echo $rows['mechant_province'] ?>" selected = "selected"><?php echo $rows['mechant_province'] ?></option>
                                                    <optgroup label="Available Provinces">
                                                        <option value="Central">Central</option>
                                                        <option value="Copperbelt">Copperbelt</option>
                                                        <option value="Eastern">Eastern</option>
                                                        <option value="Luapula">Luapula</option>
                                                        <option value="Lusaka">Lusaka</option>
                                                        <option value="Muchinga">Muchinga</option>
                                                        <option value="Nothern">Nothern</option>
                                                        <option value="North-Westen">North-Westen</option>
                                                        <option value="Southern">Southern</option>
                                                        <option value="Western">Western</option>
                                                    </optgroup>
                                                </select>
                                                </div>
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
										<div class="col-md-12">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Mechant Site:<span class="text-danger">*</span> </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="town2" id="town2" value="<?php echo $rows['mechant_town'] ?>" required="required">
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
	<script src="../ajax/Mechants.js"></script>
</body>
</html>
