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
								<h6 class="panel-title">Monthly Retail Tickets</h6>
							</div>
							<div class="col-md-6">
								<div class="text-right">
									<button type="button" class="collapsed btn btn-info" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group2"><i class="icon-search4 position-left"></i> Search</button>
								</div>
							</div>
						</div>
						<div class="row">
							<div id="accordion-control-group2" class="panel-collapse collapse">
								<form action="" method="GET">
									<div class="panel-body">
										<div class="row">
											<div class="col-md-4">
												<div class="row">
													<label class="col-md-4 control-label text-right">Client:<span style="color:red">*</span> </label>
													<div class="col-md-8">
														<select data-placeholder="Select Client" name="client" id="client" class="select-search" required="required" >
															<option></option>
															<optgroup label="Months">
																<?php
																	$sql = "SELECT * FROM clients;";
																	$stmt = $object->connect()->prepare($sql);
																	$stmt->execute();
																	while ($rows = $stmt->fetch())
																	{
																		$id = $rows['client_id'];

																		$token = $id;

																		$cipher_method = 'aes-128-ctr';
																		$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);  
																		$enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));  
																		$crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);

																		echo '<option value="'.$crypted_token.'">'.$rows['client_name'].'</option>';
																	}
																?>
															</optgroup>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="row">
													<label class="col-md-4 control-label text-right">Month:<span style="color:red">*</span> </label>
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
											<div class="col-md-4">
												<div class="row">
													<label class="col-md-4 control-label text-right">Year:<span style="color:red">*</span> </label>
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
													<button type="submit" id="getem" class="btn btn-primary"><i class="icon-search4 position-left"></i> Go</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

	                <div class="panel-body">
                        <div class="row">
                            <div class="tabbable">
                                <ul class="nav nav-tabs nav-tabs-highlight">
									<li class="active"><a href="#installation" data-toggle="tab">Installation Call</a></li>
                                    <li><a href="#general" data-toggle="tab">General Call</a></li>
                                    <li><a href="#delivery" data-toggle="tab">Delivery Call</a></li>
                                </ul>

                                <div class="tab-content" id="og_content">
									<div class="tab-pane active" id="installation">
                                        <div class="panel-body">
											<table class="table datatable-responsive datatable-button-html5-basic" style ='font-size: 11px' id="install">
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
														if(isset($_GET['month']))
														{
															$month = $_GET['month'];
															$year = $_GET['year'];
													
															$client_id = $_GET['client'];
															list($client_id, $enc_iv) = explode("::", $client_id);  
															$cipher_method = 'aes-128-ctr';
															$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
															$token = openssl_decrypt($client_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
															$client_id = $token;
															// Installation
															$install_cate = '4';
															$sql = "SELECT * FROM pos_device_calls x,device_info,client_users,mechants,pos_categories,pos_sub_categories WHERE logged_by=client_user_id AND x.call_device_serial=device_serial AND x.devcall_mechant_log_id_fk = mechant_log_id AND x.category_id_fk = category_id AND x.sub_category_id_fk = sub_category_id AND call_month=? AND call_year=? AND x.category_id_fk = ? AND clientID = ? ORDER BY x.ticket_number DESC;";
															$stmt = $object->connect()->prepare($sql);
															$stmt->bindvalue(1, $month);
															$stmt->bindvalue(2, $year);
															$stmt->bindvalue(3, $install_cate);
															$stmt->bindvalue(4, $client_id);
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
														}
													?>
												</tbody>
											</table>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="general">
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
														if(isset($_GET['month']))
														{
															//Other Calls
															$sql = "SELECT * FROM pos_device_calls x,device_info,client_users,mechants,pos_categories,pos_sub_categories WHERE logged_by=client_user_id AND x.call_device_serial=device_serial AND x.devcall_mechant_log_id_fk = mechant_log_id AND x.category_id_fk = category_id AND x.sub_category_id_fk = sub_category_id AND call_month=? AND call_year=? AND x.category_id_fk != ? AND clientID = ? ORDER BY x.ticket_number DESC;";
															$stmt = $object->connect()->prepare($sql);
															$stmt->bindvalue(1, $month);
															$stmt->bindvalue(2, $year);
															$stmt->bindvalue(3, $install_cate);
															$stmt->bindvalue(4, $client_id);
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
														if(isset($_GET['month']))
														{
															//Delivery
															$sql = "SELECT * FROM pos_delivery_calls x,client_users,mechants,pos_categories,pos_sub_categories WHERE delivery_logged_by=client_user_id AND x.delivery_mechant_log_id_fk = mechant_log_id AND x.delivery_category_id_fk = category_id AND x.delivery_sub_category_id_fk = sub_category_id AND delivery_call_month=? AND delivery_call_year=? AND clientID = ? ORDER BY x.ticket_number DESC;";
															$stmt = $object->connect()->prepare($sql);
															$stmt->bindvalue(1, $month);
															$stmt->bindvalue(2, $year);
															$stmt->bindvalue(3, $client_id);
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
				<!-- Pie Charts -->
				<?php include '../core/PieChartsMonthly.php'; ?>
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title text-semibold"><?php echo date('Y') ?> Total Call Statistics</h6>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                	</ul>
	                	</div>
					</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="chart-container text-center">
                                    <div class="display-inline-block" id="c3-pie-chart"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="chart-container text-center">
                                    <div class="display-inline-block" id="c3-pie-chart2"></div>
                                </div>
                            </div>
							<div class="col-md-4">
                                <div class="chart-container text-center">
                                    <div class="display-inline-block" id="c3-pie-chart3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
				<!-- Bars Province stats -->
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title text-semibold">Month Provincial Statistics</h6>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                	</ul>
	                	</div>
					</div>

					<div class="panel-body">
						<div class="chart-container">
							<div class="chart" id="province"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="lock-modal"></div>
    <div id="loading-circle"></div>
	<!-- <script src="../ajax/Mechants.js"></script> -->
	<script>
	// $('#getem').click(function(e){
	// 	if ($.trim($("#month").val()) === "") {
	// 		iziToast.show({
	// 			title: 'Warning!',
	// 			message: 'All Fields Are Required.',
	// 			color: 'yellow',
	// 			position: 'topRight',
	// 			icon: 'fa fa-check',
	// 			timeout: 2000
	// 		}); 
	// 		return false;
	// 	}
	// 	else{
	// 		e.preventDefault();
	// 		$(this).find('#accept_ticket').attr('disabled', 'disabled');
	// 		$("#lock-modal").css("display", "block");
	// 		$("#loading-circle").css("display", "block");
	// 		$.ajax({
	// 			type: "POST",
	// 			url: "MonthlyRetail.php",
	// 			data: $("form").serialize(),
	// 			cache: false,
	// 			processData:false,
	// 			success: function(strMessage) {
	// 				console.log(strMessage);
	// 				$("html").html($("html", strMessage).html());
	// 				// $('#accept_ticket').removeAttr('disabled');
	// 				// var xx = strMessage;
	// 				// if (xx != 'Failed' || xx != 'Error') {
	// 				// 	iziToast.show({
	// 				// 		title: 'Success!',
	// 				// 		message: 'Ticket Updated Successfully.',
	// 				// 		color: 'green',
	// 				// 		position: 'topRight',
	// 				// 		icon: 'fa fa-check',
	// 				// 		timeout: 2000
	// 				// 	});    
	// 				// 	setTimeout(function(){
	// 				// 		window.location.reload(1);
	// 				// 	}, 2500); 
	// 				// }
	// 			}
	// 		});
	// 	}
	// });
		// Pie 1 
		var pie_chart = c3.generate({
            bindto: '#c3-pie-chart',
            size: { width: 360 },
            color: {
                pattern: ['#00BCD4','#FF9800', '#4CAF50']
            },
            data: {
                columns: [
                    ["New", <?php if(isset($dum)){ echo $dum; } ?>],
                    ["Pending", <?php if(isset($dum)){ echo $dumm;} ?>],
                    ["Closed", <?php if(isset($dum)){ echo $dummy;} ?>],
                ],
                type : 'pie'
            },
			pie: {
				label: {
				format: function(value, ratio, id) {
					return value;
				}
				}
			}
        });
        // Pie 2 
        var pie_chart = c3.generate({
            bindto: '#c3-pie-chart2',
            size: { width: 360 },
            color: {
                pattern: ['#00BCD4','#FF9800', '#4CAF50', '#FF4233', '#33FFD7', '#9F33FF']
            },
            data: {
                columns: [
                    ["Hardware", <?php if(isset($dum)){  echo $hards; } ?>],
                    ["Software", <?php if(isset($dum)){  echo $softs; } ?>],
                    ["Infrastructure", <?php if(isset($dum)){ echo $inf; } ?>],
                    ["Installation", <?php if(isset($dum)){ echo $inst; } ?>],
                    ["Stationary", <?php if(isset($dum)){ echo $sta; } ?>],
                    ["Connectivity", <?php if(isset($dum)){ echo $cone; } ?>],
                ],
                type : 'pie'
            },
			pie: {
				label: {
					format: function(value, ratio, id) {
						return value;
					}
				}
			},
        });
		// Pie 3 
		var pie_chart = c3.generate({
            bindto: '#c3-pie-chart3',
            size: { width: 360 },
            color: {
                pattern: ['#00BCD4', '#9F33FF']
            },
            data: {
                columns: [
                    ["Devices", <?php if(isset($dum)){ echo $devs; } ?>],
                    ["Stationary", <?php if(isset($dum)){ echo $delis; } ?>]
                ],
                type : 'pie'
            },
			pie: {
				label: {
					format: function(value, ratio, id) {
						return value;
					}
				}
			},
        });
		// Province Bars
        var data_color = c3.generate({
            bindto: '#province',
			size: { height: 400 },
			data: {
				x : 'x',
				columns: [
					['x', 'Central', 'Copperbelt', 'Eastern', 'Luapula', 'Lusaka', 'Muchinga', 'Northern', 'North-Western','Southern','Western'],

					['Retail', <?php if(isset($dum)){ echo $central_tickets; }?>,<?php if(isset($dum)){ echo $cb_tickets; } ?>,<?php if(isset($dum)){ echo $east_tickets; } ?>,<?php if(isset($dum)){ echo $luap_tickets; } ?>, <?php if(isset($dum)){ echo $lsk_tickets; } ?>,<?php if(isset($dum)){ echo $muchi_tickets; } ?>,<?php if(isset($dum)){ echo $north_tickets; } ?>,<?php if(isset($dum)){ echo $northwest_tickets; } ?>,<?php if(isset($dum)){ echo $south_tickets; } ?>,<?php if(isset($dum)){ echo $west_tickets; } ?>],
				],
				type: 'bar',
				colors: {
					Retail: '#FF5733'
				}
			},
			
			axis: {
				x: {
					type: 'category',
					height: 80
				}
			},
			grid: {
				x: {
					show: true
				}
			}
        });
	</script>
</body>
</html>
