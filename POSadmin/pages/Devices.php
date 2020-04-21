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

<body class="navbar-bottom">
    <?php include '../includes/topnav.php'; ?>
	<!-- Page container -->
	<div class="page-container" >

		<!-- Page content -->
		<div class="page-content">

            <?php include '../includes/sidenav.php'; ?>
			<!-- Main content -->
			<div class="content-wrapper">
				<div class="panel panel-flat">
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-6">
								<h5 >POS Devices</h5>
							</div>
							<div class="col-md-6">
								<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_default"><i class="icon-plus3 position-left"></i> Add Device</button>
							</div>
						</div>
						<div id="modal_default" class="modal fade" data-backdrop="static">
							<div class="modal-dialog">
								<div class="modal-content">
									<form class="form-horizontal" id="device" action="" method="POST">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h5 class="modal-title">Add Device</h5>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<div class="col-md-12">
													<div class="row">
														<label class="col-md-4 control-label text-right">Mechant Type:<span class="text-danger">*</span> </label>
														<div class="col-md-8">
														<select data-placeholder="Select Mechant Type" name="mechtype" id="mechtype" class="select-search" required="required" onchange="getMechID(event)">
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
														<label class="col-md-4 control-label text-right">Mechant ID:<span class="text-danger">*</span> </label>
														<div class="col-md-8">
														<select data-placeholder="Select Mechant" name="mechID" id="mechID" class="select-search" required="required">
															<option></option>
														 
															</optgroup>
														</select>
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="row">
														<label class="col-md-4 control-label text-right">Device Type:<span class="text-danger">*</span> </label>
														<div class="col-md-8">
															<input type="text" name="devtype" id="devtype" class="form-control"  placeholder="Enter Device Type" required="required">
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="row">
														<label class="col-md-4 control-label text-right">Terminal ID:<span class="text-danger">*</span> </label>
														<div class="col-md-8">
															<input type="text" name="terminaID" id="terminaID" class="form-control"  placeholder="Enter Terminal ID" required="required">
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="row">
														<label class="col-md-4 control-label text-right">Device Serial:<span class="text-danger">*</span> </label>
														<div class="col-md-8">
															<input type="text" name="device_serial" id="device_serial" class="form-control"  placeholder="Enter Device Serial" required="required">
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="row">
														<label class="col-md-4 control-label text-right">PTID:<span class="text-danger">*</span> </label>
														<div class="col-md-8">
															<input type="text" name="ptid" id="ptid" class="form-control"  placeholder="Enter PTID" required="required">
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="row">
														<label class="col-md-4 control-label text-right">Base Serial: </label>
														<div class="col-md-8">
															<input type="text" name="base_serial" id="base_serial" class="form-control"  placeholder="Enter Base Serial" required="required">
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="row">
														<label class="col-md-4 control-label text-right">MTN SIM Serial: </label>
														<div class="col-md-8">
															<input type="text" name="mtn_sim_serial" id="mtn_sim_serial" class="form-control"  placeholder="Enter MTN SIM Serial" required="required">
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="row">
														<label class="col-md-4 control-label text-right">Airtel SIM Serial: </label>
														<div class="col-md-8">
															<input type="text" name="airtel_sim_serial" id="airtel_sim_serial" class="form-control"  placeholder="Enter Airtel SIM Serial" required="required">
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="row">
														<label class="col-md-4 control-label text-right">IP Address:<span class="text-danger">*</span> </label>
														<div class="col-md-8">
															<input type="text" name="ip_address" id="ip_address" class="form-control"  placeholder="Enter IP Address" required="required">
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="row">
														<label class="col-md-4 control-label text-right">FNB Asset Code:<span class="text-danger">*</span> </label>
														<div class="col-md-8">
														<input type="text" name="asset_code" id="asset_code" class="form-control"  placeholder="Enter FNB Asset Code" required="required">
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="row">
														<label class="col-md-4 control-label text-right">Installation:<span class="text-danger">*</span> </label>
														<div class="col-md-8">
															<input type="text" name="installation_date" id="installation_date" class="form-control" data-mask="99/99/9999" placeholder="Enter Installation Date" required="required">
															<span class="help-block">99/99/9999</span>
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
								<th>Terminal ID</th>
								<th>Device Serial</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$sql = "SELECT * FROM mechants,device_info WHERE mechant_log_id = mechant_log_id_fk ORDER BY mechant_province ASC;";
								$stmt = $object->connect()->prepare($sql);
								$stmt->execute();
								if($stmt->rowCount())
								{
									while ($rows = $stmt->fetch())
									{
										$id = $rows['device_id'];

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
											<td>'.$rows['terminal_id'].'</td>
											<td>'.$rows['device_serial'].'</td>

											<td>
											
											<button type="button" style ="font-size: 11px;" class="btn btn-info btn-rounded btn-xs" value="'.$crypted_token.'" data-toggle="modal" data-target="#modal_X'.$id.'""><i class="icon-eye2 "></i> </button>

											<a href="UpdateDeviceInfo?id='.$crypted_token.'" style ="font-size: 11px;" class="btn btn-warning btn-rounded btn-xs"><i class="icon-pen "></i> </a>

											
                                            <div id="modal_X'.$id.'" class="modal fade" data-backdrop="static">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form class="form-horizontal" action="" method="POST">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h5 class="modal-title">Device Details</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <label class="col-md-4 control-label text-right">Mechant Type: </label>
                                                                            <div class="col-md-8">
																			<input type="text" class="form-control" value="'.$rows['mechant_type'].'" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <label class="col-md-4 control-label text-right">Mechant Name: </label>
                                                                            <div class="col-md-8">
                                                                                <input type="text" class="form-control" value="'.$rows['mechant_name'].'" readonly>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <label class="col-md-4 control-label text-right">Mechant ID: </label>
                                                                            <div class="col-md-8">
                                                                                <input type="text" class="form-control"  value="'.$rows['mechant_id'].'" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <label class="col-md-4 control-label text-right">Province: </label>
																			<div class="col-md-8">
																			<input type="text" class="form-control" value="'.$rows['mechant_province'].'" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <label class="col-md-4 control-label text-right">Site: </label>
                                                                            <div class="col-md-8">
                                                                                <input type="text" class="form-control"  value="'.$rows['mechant_town'].'" readonly>
                                                                            </div>
                                                                        </div>
																	</div>
																	<div class="col-md-12">
																		<div class="row">
																			<label class="col-md-4 control-label text-right">Device Type: </label>
																			<div class="col-md-8">
																				<input type="text" class="form-control"  value="'.$rows['device_type'].'" readonly>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-12">
																		<div class="row">
																			<label class="col-md-4 control-label text-right">Terminal ID: </label>
																			<div class="col-md-8">
																				<input type="text" class="form-control"  value="'.$rows['terminal_id'].'" readonly>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-12">
																		<div class="row">
																			<label class="col-md-4 control-label text-right">Device Serial: </label>
																			<div class="col-md-8">
																				<input type="text" class="form-control"  value="'.$rows['device_serial'].'" readonly>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-12">
																		<div class="row">
																			<label class="col-md-4 control-label text-right">PTID:<span class="text-danger">*</span> </label>
																			<div class="col-md-8">
																				<input type="text" class="form-control"  value="'.$rows['ptid'].'" readonly>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-12">
																		<div class="row">
																			<label class="col-md-4 control-label text-right">Base Serial: </label>
																			<div class="col-md-8">
																				<input type="text" class="form-control"  value="'.$rows['base_serial'].'" readonly>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-12">
																		<div class="row">
																			<label class="col-md-4 control-label text-right">MTN SIM Serial: </label>
																			<div class="col-md-8">
																				<input type="text" class="form-control"  value="'.$rows['mtn_sim_serial'].'" readonly>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-12">
																		<div class="row">
																			<label class="col-md-4 control-label text-right">Airtel SIM Serial: </label>
																			<div class="col-md-8">
																				<input type="text" class="form-control"  value="'.$rows['airtel_sim_serial'].'" readonly>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-12">
																		<div class="row">
																			<label class="col-md-4 control-label text-right">IP Address: </label>
																			<div class="col-md-8">
																				<input type="text" class="form-control"  value="'.$rows['ip_address'].'" readonly>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-12">
																		<div class="row">
																			<label class="col-md-4 control-label text-right">FNB Asset Code: </label>
																			<div class="col-md-8">
																			<input type="text"class="form-control"  value="'.$rows['fnb_asset_code'].'" readonly>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-12">
																		<div class="row">
																			<label class="col-md-4 control-label text-right">Installation: </label>
																			<div class="col-md-8">
																				<input type="text" class="form-control"  value="'.$rows['installation_date'].'" readonly>
																			</div>
																		</div>
																	</div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
											</div>
											
                                            <button type="button" style ="font-size: 11px;" class="btn btn-danger btn-rounded btn-xs" value="'.$crypted_token.'" onclick="Deletes(this.value);"><i class="icon-trash "></i> </button>

                                            </td>
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
								<th>Terminal ID</th>
								<th>Device Serial</th>
								<th>Action</th>
							</tr>
						</tfoot>
					</table>
                </div>
			</div>
		</div>
	</div>
	<div id="lock-modal"></div>
    <div id="loading-circle"></div>
    <script src="../ajax/DeviceInfo.js"></script>
</body>
</html>
