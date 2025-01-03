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
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<div class="row">
									<div class="col-md-6">
										<h5 >Mechants</h5>
									</div>
									<!-- <div class="col-md-6">
										<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_default"><i class="icon-plus3 position-left"></i> Add Mechant</button>
									</div> -->
								</div>
								<div id="modal_default" class="modal fade" data-backdrop="static">
									<div class="modal-dialog">
										<div class="modal-content">
											<form class="form-horizontal" id="mechs" action="" method="POST">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h5 class="modal-title">Add Mechant</h5>
												</div>
												<div class="modal-body">
													<div class="form-group">
														<div class="col-md-12">
															<div class="row">
																<label class="col-md-4 control-label text-right">Mechant Type:<span class="text-danger">*</span> </label>
																<div class="col-md-8">
																<select data-placeholder="Select Mechant Type" name="mechtype" id="mechtype" class="select-search" required="required">
																	<option></option>
																	<optgroup label="Available Mechant Types">
																		<option value="Retail">Retail</option>
																		<option value="Forecourt">Forecourt</option>
																	</optgroup>
																</select>
																</div>
															</div>
														</div>
														<div class="col-md-12">
															<div class="row">
																<label class="col-md-4 control-label text-right">Mechant Name:<span class="text-danger">*</span> </label>
																<div class="col-md-8">
																	<input type="text" class="form-control" name="mechname" id="mechname" placeholder="Mechant Name" required="required">
																</div>
															</div>
														</div>
														<div class="col-md-12">
															<div class="row">
																<label class="col-md-4 control-label text-right">Mechant ID:<span class="text-danger">*</span> </label>
																<div class="col-md-8">
																	<input type="text" class="form-control" name="mechID" id="mechID" placeholder="Mechant ID" required="required">
																</div>
															</div>
														</div>
														<div class="col-md-12">
															<div class="row">
																<label class="col-md-4 control-label text-right">Province:<span class="text-danger">*</span> </label>
																<div class="col-md-8">
																<select data-placeholder="Select Province" name="prov" id="prov" class="select-search" required="required">
																	<option></option>
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
														<div class="col-md-12">
															<div class="row">
																<label class="col-md-4 control-label text-right">Site:<span class="text-danger">*</span> </label>
																<div class="col-md-8">
																	<input type="text" class="form-control" name="town" id="town" placeholder="Site" required="required">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
													<button type="button" id="save" class="btn btn-primary">Save</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							
							<table class="table datatable-responsive datatable-button-html5-basic">
								<thead>
									<tr>
										<th>Mechant Type</th>
										<th>Mechant Name</th>
										<th>Mechant ID</th>
										<th>Province</th>
										<th>Site</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$sql = "SELECT * FROM mechants ORDER BY mechant_province ASC;";
										$stmt = $object->connect()->prepare($sql);
										$stmt->execute();
										if($stmt->rowCount())
										{
											while ($rows = $stmt->fetch())
											{
												$id = $rows['mechant_log_id'];

												$token = $id;

												$cipher_method = 'aes-128-ctr';
												$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);  
												$enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));  
												$crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
											
												echo '
													<tr>
													<td>'.$rows['mechant_type'].'</td>
													<td>'.$rows['mechant_name'].'</td>
													<td>'.$rows['mechant_id'].'</td>
													<td>'.$rows['mechant_province'].'</td>
													<td>'.$rows['mechant_town'].'</td>
													
													</tr>
												';
											}								
											unset($token, $cipher_method, $enc_key, $enc_iv);
										}
									?>
								</tbody>
								<tfoot>
									<tr>
										<th>Mechant Type</th>
										<th>Mechant Name</th>
										<th>Mechant ID</th>
										<th>Province</th>
										<th>Town</th>
									</tr>
								</tfoot>
							</table>
						</div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
			</div>
		</div>
	</div>
	<div id="lock-modal"></div>
    <div id="loading-circle"></div>
	<script src="../ajax/Mechants.js"></script>
</body>
</html>
