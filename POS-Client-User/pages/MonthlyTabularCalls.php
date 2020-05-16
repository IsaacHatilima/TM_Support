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
				<div class="panel panel-flat">
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-6">
								<h6 class="panel-title">All Ticket</h6>
							</div>
							<div class="col-md-6">
								<div class="text-right">
									<button type="button" class="collapsed btn btn-info" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group2"><i class="icon-search4 position-left"></i> Search</button>
								</div>
							</div>
						</div>
						<div class="row">
							<div id="accordion-control-group2" class="panel-collapse collapse">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-6">
											<div class="row">
                                                <label class="col-md-4 control-label text-right">Month: </label>
                                                <div class="col-md-8">
													<select data-placeholder="Select Month" name="month" id="month" class="select-search" required="required" >
														<option></option>
														<optgroup label="Months">
														<option value="January">January</option>
														<option value="February">February</option>
														<option value="March">March</option>
														<option value="April">April</option>
														<option value="May">May</option>
														<option value="June">June</option>
														<option value="July">July</option>
														<option value="August">August</option>
														<option value="September">September</option>
														<option value="October">October</option>
														<option value="November">November</option>
														<option value="December">December</option>
														</optgroup>
													</select>
                                                </div>
                                            </div>
										</div>
										<div class="col-md-6">
											<div class="row">
                                                <label class="col-md-4 control-label text-right">Year: </label>
                                                <div class="col-md-8">
                                                <input type="text" name="year" id="year" class="form-control" required="required">
                                                </div>
                                            </div>
										</div>
									</div><br>
									<div class="row">
										<div class="col-md-6">
										</div>
										<div class="col-md-6">
											<div class="text-right">
												<button type="button" class="btn btn-primary"><i class="icon-search4 position-left"></i> Go</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

	                <div class="panel-body">
                        <div class="row">
                            <div class="tabbable">
                                <ul class="nav nav-tabs nav-tabs-highlight">
                                    <li class="active"><a href="#general" data-toggle="tab">General Call</a></li>
                                    <li><a href="#delivery" data-toggle="tab">Delivery Call</a></li>
                                    <!-- <li><a href="#installation" data-toggle="tab">Installation Call</a></li> -->
                                </ul>

                                <div class="tab-content" id="og_content">
                                    <div class="tab-pane active" id="general">
                                        <div class="panel-body">
											<table class="table datatable-responsive datatable-button-html5-basic" style ='font-size: 11px' id="gen">
												<thead>
													<tr>
														<th>Ticket No</th>
														<th>Mechant Type</th>
														<th>Mechant Name</th>
														<th>Province</th>
														<th>Site</th>
														<th>Device Type</th>
														<th>Category</th>
														<th>Sub Category</th>
														<th>Description of Fault</th>
														<th>Solution</th>
														<th>Time Logged</th>
														<th>Time Closed</th>
														<th>Time to Repair</th>
														<th>Logged By</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>
													<?php
													//AND client_id=logged_by
														$sql = "SELECT * FROM pos_device_calls x,device_info,client_users,mechants,pos_categories,pos_sub_categories WHERE logged_by=client_user_id AND x.call_device_serial=device_serial AND x.devcall_mechant_log_id_fk = mechant_log_id AND x.category_id_fk = category_id AND x.sub_category_id_fk = sub_category_id AND call_month=? AND call_year=? ORDER BY x.ticket_number DESC;";
														$stmt = $object->connect()->prepare($sql);
														$stmt->bindvalue(1, date('F'));
														$stmt->bindvalue(2, date('Y'));
														$stmt->execute();
														if($stmt->rowCount())
														{
															while ($rows = $stmt->fetch())
															{
																$id = $rows['ticket_number'];

																$token = $id;

																$cipher_method = 'aes-128-ctr';
																$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);  
																$enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));  
																$crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);

																if($rows['device_call_status'] == "New"){ $color = "label label-info";}
																elseif($rows['device_call_status'] == "Open"){$color = "label label-warning";}
																elseif($rows['device_call_status'] == "Closed"){$color = "label label-success";}
																elseif($rows['device_call_status'] == "Open Escalation"){$color = "label label-danger";}
																echo '
																	<tr>
																	<td><a href="POSTicketDetails?pos_ticket_id='.$crypted_token.'">'.sprintf("%04d", $rows['ticket_number']).'</a></td>
																	<td>'.$rows['mechant_type'].'</td>
																	<td>'.$rows['mechant_name'].'</td>
																	<td>'.$rows['mechant_province'].'</td>
																	<td>'.$rows['mechant_town'].'</td>
																	<td>'.$rows['device_type'].'</td>
																	<td>'.$rows['category'].'</td>
																	<td>'.$rows['sub_category'].'</td>
																	<td>'.$rows['fault_details'].'</td>
																	<td>'.$rows['solution'].'</td>
																	<td>'.$rows['date_loged'].'</td>
																	<td>'.$rows['date_closed'].'</td>
																	<td>'.$rows['repair_time'].'</td>
																	<td>'.$rows['client_user_first_name'].' '.$rows['client_user_last_name'].'</td>
																	<td><span class="label label-'. $color .'">'.$rows['device_call_status'].'</span></td>
																	</tr>
																';
															}
															
															unset($token, $cipher_method, $enc_key, $enc_iv);
														}
													?>
												</tbody>
											</table>
                                        </div>
                                        
                                    </div>
    
                                    <div class="tab-pane" id="delivery">
                                        <div class="panel-body">
											<table class="table datatable-responsive datatable-button-html5-basic" style ='font-size: 11px' id="delivery">
												<thead>
													<tr>
													<th>Ticket No</th>
													<th>Mechant Type</th>
													<th>Mechant Name</th>
													<th>Province</th>
													<th>Site</th>
													<th>Category</th>
													<th>Sub Category</th>
													<th>Item To Deliver</th>
													<th>Time Logged</th>
													<th>Time Closed</th>
													<th>Delivery Time</th>
													<th>Logged By</th>
													<th>Month</th>
													<th>Year</th>
													<th>Status</th>
													</tr>
												</thead>
												<tbody>
													<?php
													//AND client_id=logged_by
														$sql = "SELECT * FROM pos_delivery_calls x,client_users,mechants,pos_categories,pos_sub_categories WHERE delivery_logged_by=client_user_id AND x.delivery_mechant_log_id_fk = mechant_log_id AND x.delivery_category_id_fk = category_id AND x.delivery_sub_category_id_fk = sub_category_id AND delivery_call_month=? AND delivery_call_year=? ORDER BY x.ticket_number DESC;";
														$stmt = $object->connect()->prepare($sql);
														$stmt->bindvalue(1, date('F'));
														$stmt->bindvalue(2, date('Y'));
														$stmt->execute();
														if($stmt->rowCount())
														{
															while ($rows = $stmt->fetch())
															{
																$id = $rows['ticket_number'];

																$token = $id;

																$cipher_method = 'aes-128-ctr';
																$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);  
																$enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));  
																$crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);

																if($rows['delivery_call_status'] == "New"){ $color = "label label-info";}
																elseif($rows['delivery_call_status'] == "Open"){$color = "label label-warning";}
																elseif($rows['delivery_call_status'] == "Closed"){$color = "label label-success";}
																elseif($rows['delivery_call_status'] == "Open Escalation"){$color = "label label-danger";}
																echo '
																	<tr>
																	<td><a href="DeliveryTicketDetails?pos_ticket_id='.$crypted_token.'">'.sprintf("%04d", $rows['ticket_number']).'</a></td>
																	<td>'.$rows['mechant_type'].'</td>
																	<td>'.$rows['mechant_name'].'</td>
																	<td>'.$rows['mechant_province'].'</td>
																	<td>'.$rows['mechant_town'].'</td>
																	<td>'.$rows['category'].'</td>
																	<td>'.$rows['sub_category'].'</td>
																	<td>'.$rows['item_to_deliver'].'</td>
																	<td>'.$rows['delivery_date_loged'].'</td>
																	<td>'.$rows['delivery_date_closed'].'</td>
																	<td>'.$rows['resolution_time'].'</td>
																	<td>'.$rows['client_user_first_name'].' '.$rows['client_user_last_name'].'</td>
																	<td>'.$rows['delivery_call_month'].'</td>
																	<td>'.$rows['delivery_call_year'].'</td>
																	<td><span class="label label-'. $color .'">'.$rows['delivery_call_status'].'</span></td>
																	</tr>
																';
															}
															
															unset($token, $cipher_method, $enc_key, $enc_iv);
														}
													?>
												</tbody>
											</table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<div id="lock-modal"></div>
    <div id="loading-circle"></div>
	<script src="../ajax/Mechants.js"></script>
</body>
</html>
