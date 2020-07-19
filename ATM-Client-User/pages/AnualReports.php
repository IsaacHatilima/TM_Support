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
								<h6 class="panel-title">Annual Tickets</h6>
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
													<label class="col-md-4 control-label text-right">Year:<span style="color:red">*</span> </label>
													<div class="col-md-8">
													<input type="text" name="year" class="form-control" placeholder="Enter Year">
													</div>
												</div>
											</div>
                                            <!-- 
											<div class="col-md-4">
												<div class="row">
													<label class="col-md-4 control-label text-right">End Date:<span style="color:red">*</span> </label>
													<div class="col-md-8">
													<input type="text" name="enddate" id="enddate" class="form-control" data-mask="9999-99-99" placeholder="Enter Ending date">
													<span class="help-block">yyyy-mm-dd</span>
													</div>
												</div>
											</div> -->
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
									<li class="active"><a href="#installation" data-toggle="tab">Closed Call</a></li>
                                    <li><a href="#general" data-toggle="tab">Open Call</a></li>
                                    <li><a href="#delivery" data-toggle="tab">New Call</a></li>
                                </ul>

                                <div class="tab-content" id="og_content">
                                
									<div class="tab-pane active" id="installation">
                                        <div class="panel-body">
											<table class="table datatable-responsive datatable-button-html5-basic" style ='font-size: 11px' id="install">
												<thead>
													<tr>
														<th>Ticket ID</th>
														<th>Status</th>
														<th>Site</th>
														<th>ATM Name</th>
														<th>Category</th>
														<th>Sub Category</th>
														<th>Description of Fault</th>
														<th>Solution</th>
														<th>Reason for Delay</th>
														<th>Custodian Status</th>
														<th>Logged By</th>
														<th>Time Logged</th>
														<th>Time Closed</th>
														<th>Repair Time</th>
														<th>Assg. Engineer</th>
													</tr>
												</thead>
												<tbody>
													<?php
														if(isset($_GET['client']))
														{
															$year = $_GET['year'];
															//$end = $_GET['enddate'];

															$client_id = $_GET['client'];
															list($client_id, $enc_iv) = explode("::", $client_id);
															$cipher_method = 'aes-128-ctr';
															$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
															$token = openssl_decrypt($client_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
															$client_id = $token;
															$sql = "SELECT * FROM atm_calls f,clients,atm_details, client_users,atm_categories,atm_sub_categories,engineers WHERE client_id=f.client_id_fk AND atm_id=atm_id_fk AND client_user_id = logged_by AND category_id=f.category_id_fk AND sub_category_id=sub_category_id_fk AND engineer_id=engineer_on_site AND f.client_id_fk=? AND log_year=? AND call_status='Closed';";
															$stmt = $object->connect()->prepare($sql);
															$stmt->bindvalue(1, $client_id);
															$stmt->bindvalue(2, $year);
															$stmt->execute();
															if($stmt->rowCount())
															{
																while ($rows = $stmt->fetch())
																{
																	$id = $rows['call_id'];

																	$token = $id;

																	$cipher_method = 'aes-128-ctr';
																	$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
																	$enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
																	$crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);

																	if($rows['call_status'] == "New"){ $color = "label label-info";}
																	elseif($rows['call_status'] == "Open"){$color = "label label-warning";}
																	elseif($rows['call_status'] == "Closed"){$color = "label label-success";}
																	echo '
																		<tr>
																		<td><a href="ATMTicketDetails?atm_ticket_id='.$crypted_token.'">'.sprintf("%04d", $rows['call_id']).'</a></td>
																		<td><span class="label label-'. $color .'">'.$rows['call_status'].'</span></td>
																		<td>'.$rows['atm_site'].'</td>
																		<td>'.$rows['atm_name'].'('.$rows['atm_model'].'/'.$rows['atm_type'].')</td>
																		<td>'.$rows['category'].'</td>
																		<td>'.$rows['sub_category'].'</td>
																		<td>'.$rows['fault_details'].'</td>
																		<td>'.$rows['solution'].'</td>
																		<td>'.$rows['reson_for_delay'].'</td>
																		<td>'.$rows['custodian_status'].'</td>
																		<td>'.$rows['client_user_first_name'].' '.$rows['client_user_last_name'].'</td>
																		<td>'.$rows['time_logged'].'</td>
																		<td>'.$rows['close_time'].'</td>
																		<td>'.$rows['resolution_time'].'</td>
																		<td>'.$rows['engineer_first_name'].' '.$rows['engineer_last_name'].'</td>
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
														<th>Ticket ID</th>
														<th>Status</th>
														<th>Site</th>
														<th>ATM Name</th>
														<th>Category</th>
														<th>Sub Category</th>
														<th>Description of Fault</th>
														<th>Solution</th>
														<th>Reason for Delay</th>
														<th>Custodian Status</th>
														<th>Logged By</th>
														<th>Time Logged</th>
														<th>Time Closed</th>
														<th>Repair Time</th>
														<th>Assg. Engineer</th>
													</tr>
												</thead>
												<tbody>
													<?php
														if(isset($_GET['client']))
														{
															$year = $_GET['year'];
															//$end = $_GET['enddate'];

															$client_id = $_GET['client'];
															list($client_id, $enc_iv) = explode("::", $client_id);
															$cipher_method = 'aes-128-ctr';
															$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
															$token = openssl_decrypt($client_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
															$client_id = $token;
															$sql = "SELECT * FROM atm_calls f,clients,atm_details, client_users,atm_categories,atm_sub_categories,engineers WHERE client_id=f.client_id_fk AND atm_id=atm_id_fk AND client_user_id = logged_by AND category_id=f.category_id_fk AND sub_category_id=sub_category_id_fk AND engineer_id=engineer_on_site AND f.client_id_fk=? AND log_year=? AND call_status='Open';";
															$stmt = $object->connect()->prepare($sql);
															$stmt->bindvalue(1, $client_id);
															$stmt->bindvalue(2, $year);
															$stmt->execute();
															if($stmt->rowCount())
															{
																while ($rows = $stmt->fetch())
																{
																	$id = $rows['call_id'];

																	$token = $id;

																	$cipher_method = 'aes-128-ctr';
																	$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
																	$enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
																	$crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);

																	if($rows['call_status'] == "New"){ $color = "label label-info";}
																	elseif($rows['call_status'] == "Open"){$color = "label label-warning";}
																	elseif($rows['call_status'] == "Closed"){$color = "label label-success";}
																	echo '
																		<tr>
																		<td><a href="ATMTicketDetails?atm_ticket_id='.$crypted_token.'">'.sprintf("%04d", $rows['call_id']).'</a></td>
																		<td><span class="label label-'. $color .'">'.$rows['call_status'].'</span></td>
																		<td>'.$rows['atm_site'].'</td>
																		<td>'.$rows['atm_name'].'('.$rows['atm_model'].'/'.$rows['atm_type'].')</td>
																		<td>'.$rows['category'].'</td>
																		<td>'.$rows['sub_category'].'</td>
																		<td>'.$rows['fault_details'].'</td>
																		<td>'.$rows['solution'].'</td>
																		<td>'.$rows['reson_for_delay'].'</td>
																		<td>'.$rows['custodian_status'].'</td>
																		<td>'.$rows['client_user_first_name'].' '.$rows['client_user_last_name'].'</td>
																		<td>'.$rows['time_logged'].'</td>
																		<td>'.$rows['close_time'].'</td>
																		<td>'.$rows['resolution_time'].'</td>
																		<td>'.$rows['engineer_first_name'].' '.$rows['engineer_last_name'].'</td>
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
														<th>Ticket ID</th>
														<th>Status</th>
														<th>Site</th>
														<th>ATM Name</th>
														<th>Category</th>
														<th>Sub Category</th>
														<th>Description of Fault</th>
														<th>Solution</th>
														<th>Reason for Delay</th>
														<th>Custodian Status</th>
														<th>Logged By</th>
														<th>Time Logged</th>
														<th>Time Closed</th>
														<th>Repair Time</th>
														<th>Assg. Engineer</th>
													</tr>
												</thead>
												<tbody>
													<?php
														if(isset($_GET['client']))
														{
															$year = $_GET['year'];
															//$end = $_GET['enddate'];

															$client_id = $_GET['client'];
															list($client_id, $enc_iv) = explode("::", $client_id);
															$cipher_method = 'aes-128-ctr';
															$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
															$token = openssl_decrypt($client_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
															$client_id = $token;
															$sql = "SELECT * FROM atm_calls f,clients,atm_details, client_users,atm_categories,atm_sub_categories,engineers WHERE client_id=f.client_id_fk AND atm_id=atm_id_fk AND client_user_id = logged_by AND category_id=f.category_id_fk AND sub_category_id=sub_category_id_fk AND engineer_id=engineer_on_site AND f.client_id_fk=? AND log_year=? AND call_status='New';";
															$stmt = $object->connect()->prepare($sql);
															$stmt->bindvalue(1, $client_id);
															$stmt->bindvalue(2, $year);
															$stmt->execute();
															if($stmt->rowCount())
															{
																while ($rows = $stmt->fetch())
																{
																	$id = $rows['call_id'];

																	$token = $id;

																	$cipher_method = 'aes-128-ctr';
																	$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
																	$enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
																	$crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);

																	if($rows['call_status'] == "New"){ $color = "label label-info";}
																	elseif($rows['call_status'] == "Open"){$color = "label label-warning";}
																	elseif($rows['call_status'] == "Closed"){$color = "label label-success";}
																	echo '
																		<tr>
																		<td><a href="ATMTicketDetails?atm_ticket_id='.$crypted_token.'">'.sprintf("%04d", $rows['call_id']).'</a></td>
																		<td><span class="label label-'. $color .'">'.$rows['call_status'].'</span></td>
																		<td>'.$rows['atm_site'].'</td>
																		<td>'.$rows['atm_name'].'('.$rows['atm_model'].'/'.$rows['atm_type'].')</td>
																		<td>'.$rows['category'].'</td>
																		<td>'.$rows['sub_category'].'</td>
																		<td>'.$rows['fault_details'].'</td>
																		<td>'.$rows['solution'].'</td>
																		<td>'.$rows['reson_for_delay'].'</td>
																		<td>'.$rows['custodian_status'].'</td>
																		<td>'.$rows['client_user_first_name'].' '.$rows['client_user_last_name'].'</td>
																		<td>'.$rows['time_logged'].'</td>
																		<td>'.$rows['close_time'].'</td>
																		<td>'.$rows['resolution_time'].'</td>
																		<td>'.$rows['engineer_first_name'].' '.$rows['engineer_last_name'].'</td>
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
				<?php include '../core/AnualCalls.php'; ?>
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title text-semibold"> Total Call Statistics</h6>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                	</ul>
	                	</div>
					</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="chart-container text-center">
                                    <div class="display-inline-block" id="c3-pie-chart"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container text-center">
                                    <div class="display-inline-block" id="c3-pie-chart2"></div>
                                </div>
                            </div>
							<!-- <div class="col-md-4">
                                <div class="chart-container text-center">
                                    <div class="display-inline-block" id="c3-pie-chart3"></div>
                                </div>
                            </div> -->
                        </div>
                    </div>
				</div>
				<!-- Bars Province stats -->
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title text-semibold">Anual Provincial Statistics</h6>
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

				<!-- Users Province stats -->
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title text-semibold">Request User Statistics</h6>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                	</ul>
	                	</div>
					</div>

					<div class="panel-body">
						<div class="chart-container">
							<div class="chart" id="userz"></div>
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
                pattern: ['#00BCD4','#FF9800']
            },
            data: {
                columns: [
                    ["Hardware", <?php if(isset($dum)){  echo $hards; } ?>],
                    ["Software", <?php if(isset($dum)){  echo $softs; } ?>],
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
		// var pie_chart = c3.generate({
        //     bindto: '#c3-pie-chart3',
        //     size: { width: 360 },
        //     color: {
        //         pattern: ['#00BCD4', '#9F33FF']
        //     },
        //     data: {
        //         columns: [
        //             ["Devices", <?php //if(isset($dum)){ echo $devs; } ?>],
        //             ["Stationary", <?php //if(isset($dum)){ echo $delis; } ?>]
        //         ],
        //         type : 'pie'
        //     },
		// 	pie: {
		// 		label: {
		// 			format: function(value, ratio, id) {
		// 				return value;
		// 			}
		// 		}
		// 	},
        // });
		// Province Bars
        // var data_color = c3.generate({
        //     bindto: '#province',
		// 	size: { height: 400 },
		// 	data: {
		// 		x : 'x',
		// 		columns: [
		// 			['x', 'Central', 'Copperbelt', 'Eastern', 'Luapula', 'Lusaka', 'Muchinga', 'Northern', 'North-Western','Southern','Western'],

		// 			['Forecourt', <?php if(isset($dum)){ echo $central_tickets; }?>,<?php if(isset($dum)){ echo $cb_tickets; } ?>,<?php if(isset($dum)){ echo $east_tickets; } ?>,<?php if(isset($dum)){ echo $luap_tickets; } ?>, <?php if(isset($dum)){ echo $lsk_tickets; } ?>,<?php if(isset($dum)){ echo $muchi_tickets; } ?>,<?php if(isset($dum)){ echo $north_tickets; } ?>,<?php if(isset($dum)){ echo $northwest_tickets; } ?>,<?php if(isset($dum)){ echo $south_tickets; } ?>,<?php if(isset($dum)){ echo $west_tickets; } ?>],
		// 		],
		// 		type: 'bar',
		// 		colors: {
		// 			Forecourt: '#FF5733'
		// 		}
		// 	},

		// 	axis: {
		// 		x: {
		// 			type: 'category',
		// 			height: 80
		// 		}
		// 	},
		// 	grid: {
		// 		x: {
		// 			show: true
		// 		}
		// 	}
        // });

		// Province Bars
		var data_color = c3.generate({
            bindto: '#province',
			size: { height: 400 },
			data: {
				x : 'x',
				columns: [
					['x', 	<?php 
								if(isset($client_id))
								{
									$sql = "SELECT province FROM atm_details GROUP BY province;";
									$stmt = $object->connect()->prepare($sql);
									// $stmt->bindvalue(1, $client_id);
									$stmt->execute();
									if($stmt->rowCount())
									{
										while ($rows = $stmt->fetch())
										{
											echo '"'. $rows['province'].'"'.',';
										}
									}
								} 
							?>],
					<?php
						if(isset($client_id))
						{
							$sql = "SELECT province FROM atm_details GROUP BY province;";
							$stmt = $object->connect()->prepare($sql);
							// $stmt->bindvalue(1, $client_id);
							$stmt->execute();
							if($stmt->rowCount())
							{
								while ($rows = $stmt->fetch())
								{
									// First
									$sql1 = "SELECT COUNT(call_id) AS firsts FROM atm_calls f,atm_details WHERE log_year=? AND f.client_id_fk=? AND atm_id_fk=atm_id AND province=?;";
									$stmt1 = $object->connect()->prepare($sql1);
									$stmt1->bindvalue(1, $year);
									$stmt1->bindvalue(2, $client_id);
									$stmt1->bindvalue(3, $rows['province']);
									$stmt1->execute();
									$rows1 = $stmt1->fetch();
									echo "['".$rows['province']."', $rows1[firsts]],";
									
								}
							}
						}
					?>
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

		// User Bars
		var data_color = c3.generate({
            bindto: '#userz',
			size: { height: 400 },
			data: {
				x : 'x',
				columns: [
					['x', 'Total Logged Calls'],
					<?php
						if(isset($client_id))
						{
							$sql = "SELECT * FROM client_users WHERE client_id_fk=?;";
							$stmt = $object->connect()->prepare($sql);
							$stmt->bindvalue(1, $client_id);
							$stmt->execute();
							if($stmt->rowCount())
							{
								while ($rows = $stmt->fetch())
								{
									$sql2 = "SELECT COUNT(call_id) AS tots FROM atm_calls WHERE logged_by=? AND client_id_fk=? AND log_year = ?;";
									$stmt2 = $object->connect()->prepare($sql2);
									$stmt2->bindvalue(1, $rows['client_user_id']);
									$stmt2->bindvalue(2, $client_id);
									$stmt2->bindvalue(3, $year);
									$stmt2->execute();
									$rows2 = $stmt2->fetch();
									$tots = $rows2['tots'];
									echo "['".$rows['client_user_first_name']." . ".$rows['client_user_last_name'][0]."', $tots],";
								}
							}
						}
					?>
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
