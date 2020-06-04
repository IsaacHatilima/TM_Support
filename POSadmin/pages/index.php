
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include '../includes/header.php'; ?>
	<script type="text/javascript" src="../../assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
	<script type="text/javascript" src="../../assets/js/pages/datatables_extension_buttons_html5.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/tables/datatables/extensions/responsive.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
	<script type="text/javascript" src="../../assets/js/pages/datatables_responsive.js"></script>
</head>

<body class="navbar-bottom navbar-top">
	<?php include '../includes/topnav.php'; ?>


	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title">Ticket Snipet</h6>
					</div>
					<!-- <div class="container-fluid"> -->
						<div class="row">
							<div class="col-lg-4">
								<ul class="list-inline text-center">
									<li>
										<span class="btn border-info text-info btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-plus3"></i></span>
									</li>
									<li class="text-left">
										<div class="text-semibold">New</div>
										<?php
											$status = 'New';
											$sqle = "SELECT COUNT(device_call_id) AS yanew FROM pos_device_calls WHERE device_call_status=?;";
											$stmte = $object->connect()->prepare($sqle);
											$stmte->bindvalue(1,$status);
											if($stmte->execute())
											{
												$rowz = $stmte->fetch(PDO::FETCH_ASSOC);
											}
										?>
										<div class="text-muted"><?php echo $rowz['yanew']; ?></div>
									</li>
								</ul>
							</div>
							<div class="col-lg-4">
								<ul class="list-inline text-center">
									<li>
										<span class="btn border-warning-400 text-warning-400 btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-notification2"></i></span>
									</li>
									<li class="text-left">
										<div class="text-semibold">Open</div>
										<?php
											$status = 'Open';
											$sqle = "SELECT COUNT(device_call_id) AS yanew FROM pos_device_calls WHERE device_call_status=?;";
											$stmte = $object->connect()->prepare($sqle);
											$stmte->bindvalue(1,$status);
											if($stmte->execute())
											{
												$rowz = $stmte->fetch(PDO::FETCH_ASSOC);
											}
										?>
										<div class="text-muted"><?php echo $rowz['yanew']; ?></div>
									</li>
								</ul>
							</div>
							<div class="col-lg-4">
								<ul class="list-inline text-center">
									<li>
										<span  class="btn border-success text-success btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-checkmark-circle"></i></span>
									</li>
									<li class="text-left">
										<div class="text-semibold">Closed</div>
										<?php
											$status = 'Closed';
											$sqle = "SELECT COUNT(device_call_id) AS yanew FROM pos_device_calls WHERE device_call_status=?;";
											$stmte = $object->connect()->prepare($sqle);
											$stmte->bindvalue(1,$status);
											if($stmte->execute())
											{
												$rowz = $stmte->fetch(PDO::FETCH_ASSOC);
											}
										?>
										<div class="text-muted"><?php echo $rowz['yanew']; ?></div>
									</li>
								</ul>
							</div>
						</div>
					<!-- </div> -->
				</div>
				<div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title">Recent Calls</h6>
					</div>

	                <div class="panel-body">
                        <div class="row">
                            <div class="tabbable">
                                <ul class="nav nav-tabs nav-tabs-highlight">
                                    <li class="active"><a href="#general" data-toggle="tab">General Call</a></li>
                                    <li><a href="#delivery" data-toggle="tab">Delivery Call</a></li>
                                    <!-- <li><a href="#installation" data-toggle="tab">Installation Call</a></li> -->
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="general">
                                        <div class="panel-body">
											<table class="table datatable-responsive datatable-button-html5-basic" style ='font-size: 11px'>
												<thead>
													<tr>
														<th>Ticket No</th>
														<th>Mechant Name</th>
														<th>Site</th>
														<th>Device Type</th>
														<th>Category</th>
														<th>Sub Category</th>
														<th>Description of Fault</th>
														<th>Logged By</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>
													<?php
													//AND client_id=logged_by
														$sql = "SELECT * FROM pos_device_calls x,device_info,client_users,mechants,pos_categories,pos_sub_categories WHERE logged_by=client_user_id AND x.call_device_serial=device_serial AND x.devcall_mechant_log_id_fk = mechant_log_id AND x.category_id_fk = category_id AND x.sub_category_id_fk = sub_category_id ORDER BY x.device_call_id DESC LIMIT 10;";
														$stmt = $object->connect()->prepare($sql);
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
																	<td>'.$rows['mechant_name'].' ('.$rows['mechant_type'].')</td>
																	<td>'.$rows['mechant_town'].' ('.$rows['mechant_province'].')</td>
																	<td>'.$rows['device_type'].'</td>
																	<td>'.$rows['category'].'</td>
																	<td>'.$rows['sub_category'].'</td>
																	<td>'.$rows['fault_details'].'</td>
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
									<!-- Delivery -->
                                    <div class="tab-pane" id="delivery">
                                        <div class="panel-body">
										<table class="table datatable-responsive datatable-button-html5-basic" style ='font-size: 11px' id="delivery">
												<thead>
													<tr>
														<th>Ticket No</th>
														<th>Mechant Name</th>
														<th>Site</th>
														<th>Category</th>
														<th>Sub Category</th>
														<th>Item To Deliver</th>
														<th>Logged By</th>
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
																	<td>'.$rows['mechant_name'].'('.$rows['mechant_type'].')</td>
																	<td>'.$rows['mechant_town'].'('.$rows['mechant_province'].')</td>
																	<td>'.$rows['category'].'</td>
																	<td>'.$rows['sub_category'].'</td>
																	<td>'.$rows['item_to_deliver'].'</td>
																	<td>'.$rows['client_user_first_name'].' '.$rows['client_user_last_name'].'</td>
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
 
				<!-- Chart 1 code -->
				<?php include '../core/IndexChart.php'; ?>               
                <div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title text-semibold"><?php echo date('F') ?> Monthly Statistics</h6>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                	</ul>
	                	</div>
					</div>
					<div class="panel-body">
						<div class="chart-container">
							<div class="chart" id="homechart"></div>
						</div>
					</div>
                </div>               
				<!-- Chart 2 code -->
				<?php include '../core/IndexChart2.php'; ?>
                <div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title text-semibold"><?php echo date('Y') ?> Yearly Analysis</h6>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                	</ul>
	                	</div>
					</div>

					<div class="panel-body">
						<div class="chart-container">
							<div class="chart" id="yearsChart"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		var axis_tick_rotation = c3.generate({
			bindto: '#homechart',
			size: { height: 400 },
			data: {
				x : 'x',
				columns: [
					['x', 'Hardware', 'Software', 'Infrastructure', 'Installation', 'Stationary', 'Connectivity'],

					['Retail', <?php echo $Rhard['Rhardware']; ?>, <?php echo $Rsoft['Rsoftware']; ?>, <?php echo $Rinfra['Rinfra']; ?>, <?php echo $Rinstall['Rinstall']; ?>,  <?php echo $Rstation['Rstation']; ?>, <?php echo $Rconnect['Rconnect']; ?>],

					['Forecourt', <?php echo $Fhard['Fhardware']; ?>, <?php echo $Fsoft['Fsoftware']; ?>, <?php echo $Finfra['Finfra']; ?>, <?php echo $Finstall['Finstall']; ?>, <?php echo $Fstation['Fstation']; ?>, <?php echo $Fconnect['Fconnect']; ?>]
				],
				type: 'bar',
				colors: {
					Retail: 'aqua',
					Forecourt: 'teal'
				}
			},
			
			axis: {
				x: {
					type: 'category',
					// tick: {
					// 	rotate: 180
					// },
					height: 80
				}
			},
			grid: {
				x: {
					show: true
				}
			}
		});

        // Yearly Chart
		var axis_tick_rotation = c3.generate({
			bindto: '#yearsChart',
			size: { height: 400 },
			data: {
				x : 'x',
				columns: [
					['x', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

					['Retail', <?php echo $Rjan['Rjan']; ?>, <?php echo $Rfeb['Rfeb']; ?>, <?php echo $Rmar['Rmar']; ?>, <?php echo $Rapr['Rapr']; ?>,  <?php echo $Rmay['Rmay']; ?>, <?php echo $Rjun['Rjun']; ?>,<?php echo $Rjul['Rjul']; ?>,<?php echo $Raug['Raug']; ?>,<?php echo $Rsep['Rsep']; ?>,<?php echo $Roct['Roct']; ?>,<?php echo $Rnov['Rnov']; ?>,<?php echo $Rdec['Rdec']; ?>],

					['Forecourt', <?php echo $Fjan['Fjan']; ?>, <?php echo $Ffeb['Ffeb']; ?>, <?php echo $Fmar['Fmar']; ?>, <?php echo $Fapr['Fapr']; ?>,  <?php echo $Fmay['Fmay']; ?>, <?php echo $Fjun['Fjun']; ?>,<?php echo $Fjul['Fjul']; ?>,<?php echo $Faug['Faug']; ?>,<?php echo $Fsep['Fsep']; ?>,<?php echo $Foct['Foct']; ?>,<?php echo $Fnov['Fnov']; ?>,<?php echo $Fdec['Fdec']; ?>]
				],
				type: 'bar',
				colors: {
					Retail: 'aqua',
					Forecourt: 'teal'
				}
			},
			
			axis: {
				x: {
					type: 'category',
					// tick: {
					// 	rotate: 180
					// },
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
