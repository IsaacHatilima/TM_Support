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
										<h5 >Repaired Devices</h5>
									</div>
									<div class="col-md-6">
										<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_default"><i class="icon-plus3 position-left"></i> Add Device</button>
									</div>
								</div>
								<div id="modal_default" class="modal fade" data-backdrop="static">
									<div class="modal-dialog">
										<div class="modal-content">
											<form class="form-horizontal" id="repair_device" action="" method="POST">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h5 class="modal-title">Add Device</h5>
												</div>
												<div class="modal-body">
													<div class="form-group">
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
																<label class="col-md-4 control-label text-right">Device Serial:<span class="text-danger">*</span> </label>
																<div class="col-md-8">
																	<input type="text" name="device_serial" id="device_serial" class="form-control"  placeholder="Enter Device Serial" required="required">
																</div>
															</div>
														</div>
														<div class="col-md-12">
															<div class="row">
																<label class="col-md-4 control-label text-right">Device PTID:<span class="text-danger">*</span> </label>
																<div class="col-md-8">
																	<input type="text" name="ptid" id="ptid" class="form-control"  placeholder="Enter Device PTID" required="required">
																</div>
															</div>
														</div>
														<div class="col-md-12">
															<div class="row">
																<label class="col-md-4 control-label text-right">Warranty Sticker:<span class="text-danger">*</span> </label>
																<div class="col-md-8">
																	<input type="text" name="warranty" id="warranty" class="form-control"  placeholder="Open or Sealed" required="required">
																</div>
															</div>
														</div>
														<div class="col-md-12">
															<div class="row">
																<label class="col-md-4 control-label text-right">Fault on Screen:<span class="text-danger">*</span> </label>
																<div class="col-md-8">
																	<input type="text" name="fault" id="fault" class="form-control"  placeholder="Enter Fault on Screen" required="required">
																</div>
															</div>
														</div>
														<div class="col-md-12">
															<div class="row">
																<label class="col-md-4 control-label text-right">General Problem:<span class="text-danger">*</span> </label>
																<div class="col-md-8">
																	<textarea rows="5" cols="5" name="gen_prob" id="gen_prob"  class="form-control" placeholder="Default textarea" required="required"></textarea>
																</div>
															</div>
														</div>
														<div class="col-md-12">
															<div class="row">
																<label class="col-md-4 control-label text-right">Parts Used:<span class="text-danger">*</span> </label>
																<div class="col-md-8">
																<textarea rows="5" cols="5" name="parts_used" id="parts_used"  class="form-control" placeholder="Default textarea" required="required"></textarea>
																</div>
															</div>
														</div>
														<div class="col-md-12">
															<div class="row">
																<label class="col-md-4 control-label text-right">EOS Reloaded:<span class="text-danger">*</span> </label>
																<div class="col-md-8">
																	<select data-placeholder="Select One" name="eos_reload" id="eos_reload" class="select-search" required="required">
																		<option></option>
																		<optgroup label="Available Options">
																			<option value="Yes">Yes</option>
																			<option value="No">No</option>
																		</optgroup>
																	</select>
																</div>
															</div>
														</div>
														<div class="col-md-12">
															<div class="row">
																<label class="col-md-4 control-label text-right">Date Repaired:<span class="text-danger">*</span> </label>
																<div class="col-md-8">
																	<input type="text" name="repaire_date" id="repaire_date" class="form-control" data-mask="99/99/9999" placeholder="Enter Repaire Date" required="required">
																	<span class="help-block">99/99/9999</span>
																</div>
															</div>
														</div>
														<div class="col-md-12">
															<div class="row">
																<label class="col-md-4 control-label text-right">Final Test:<span class="text-danger">*</span> </label>
																<div class="col-md-8">
																	<input type="text" name="final_test" id="final_test" class="form-control"  placeholder="Enter Final Test" required="required">
																</div>
															</div>
														</div>
														<div class="col-md-12">
															<div class="row">
																<label class="col-md-4 control-label text-right">Comment:<span class="text-danger">*</span> </label>
																<div class="col-md-8">
																	<input type="text" name="comment" id="comment" class="form-control"  placeholder="Enter Comment" required="required">
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
										<th>Device Type</th>
										<th>Serial Number</th>
										<th>PTID</th>
										<th>Fault on Screen</th>
										<th>EOS Reload</th>
										<th>Final Test</th>
										<th>Date Repaired</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$sql = "SELECT * FROM device_repair ORDER BY repair_id DESC;";
										$stmt = $object->connect()->prepare($sql);
										$stmt->execute();
										if($stmt->rowCount())
										{
											while ($rows = $stmt->fetch())
											{
												$id = $rows['repair_id'];

												$token = $id;

												$cipher_method = 'aes-128-ctr';
												$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);  
												$enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));  
												$crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
											
												echo '
													<tr>
													<td>'.$rows['device_type'].'</td>
													<td>'.$rows['device_serial'].'</td>
													<td>'.$rows['ptid'].'</td>
													<td>'.$rows['fault_on_screen'].'</td>
													<td>'.$rows['eos_reload'].'</td>
													<td>'.$rows['final_test'].'</td>
													<td>'.$rows['date_repaired'].'</td>

													<td>
													
													<button type="button" style ="font-size: 11px;" class="btn btn-info btn-rounded btn-xs" value="'.$crypted_token.'" data-toggle="modal" data-target="#modal_X'.$id.'""><i class="icon-eye2 "></i> </button>
													
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
																					<label class="col-md-4 control-label text-right">Device Type:<span class="text-danger">*</span> </label>
																					<div class="col-md-8">
																						<input type="text" value="'.$rows['device_type'].'" readonly class="form-control" >
																					</div>
																				</div>
																			</div>
																			<div class="col-md-12">
																				<div class="row">
																					<label class="col-md-4 control-label text-right">Device Serial:<span class="text-danger">*</span> </label>
																					<div class="col-md-8">
																						<input type="text" value="'.$rows['device_serial'].'" readonly class="form-control">
																					</div>
																				</div>
																			</div>
																			<div class="col-md-12">
																				<div class="row">
																					<label class="col-md-4 control-label text-right">Device Serial:<span class="text-danger">*</span> </label>
																					<div class="col-md-8">
																						<input type="text" value="'.$rows['ptid'].'" readonly class="form-control">
																					</div>
																				</div>
																			</div>
																			<div class="col-md-12">
																				<div class="row">
																					<label class="col-md-4 control-label text-right">Warranty Sticker: </label>
																					<div class="col-md-8">
																						<input type="text" value="'.$rows['warrant_sticker'].'" readonly class="form-control">
																					</div>
																				</div>
																			</div>
																			<div class="col-md-12">
																				<div class="row">
																					<label class="col-md-4 control-label text-right">Fault on Screen: </label>
																					<div class="col-md-8">
																						<input type="text" value="'.$rows['fault_on_screen'].'" readonly class="form-control" >
																					</div>
																				</div>
																			</div>
																			<div class="col-md-12">
																				<div class="row">
																					<label class="col-md-4 control-label text-right">General Problem: </label>
																					<div class="col-md-8">
																						<textarea readonly rows="5" cols="5" class="form-control" placeholder="Default textarea">'.$rows['general_problem'].'</textarea>
																					</div>
																				</div>
																			</div>
																			<div class="col-md-12">
																				<div class="row">
																					<label class="col-md-4 control-label text-right">Parts Used: </label>
																					<div class="col-md-8">
																					<textarea rows="5" cols="5" class="form-control" readonly>'.$rows['parts_used'].'</textarea>
																					</div>
																				</div>
																			</div>
																			<div class="col-md-12">
																				<div class="row">
																					<label class="col-md-4 control-label text-right">EOS Reloaded: </label>
																					<div class="col-md-8">
																						<input type="text" value="'.$rows['eos_reload'].'" readonly class="form-control" >
																					</div>
																				</div>
																			</div>
																			<div class="col-md-12">
																				<div class="row">
																					<label class="col-md-4 control-label text-right">Date Repaired: </label>
																					<div class="col-md-8">
																						<input type="text" value="'.$rows['date_repaired'].'" readonly class="form-control" >
																					</div>
																				</div>
																			</div>
																			<div class="col-md-12">
																				<div class="row">
																					<label class="col-md-4 control-label text-right">Final Test: </label>
																					<div class="col-md-8">
																					<input type="text" value="'.$rows['final_test'].'" class="form-control" readonly >
																					</div>
																				</div>
																			</div>
																			<div class="col-md-12">
																				<div class="row">
																					<label class="col-md-4 control-label text-right">Comment: </label>
																					<div class="col-md-8">
																						<input type="text" value="'.$rows['status_comment'].'" readonly class="form-control" >
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
										<th>Device Type</th>
										<th>Serial Number</th>
										<th>PTID</th>
										<th>Fault on Screen</th>
										<th>EOS Reload</th>
										<th>Final Test</th>
										<th>Date Repaired</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
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
</body>
</html>
