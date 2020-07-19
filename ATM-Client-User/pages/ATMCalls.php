
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
						<h6 class="panel-title">All Calls</h6>
					</div>

	                <div class="panel-body">
                        <div class="row">
                            <div class="tabbable">
                                <ul class="nav nav-tabs nav-tabs-highlight">
                                    <li class="active"><a href="#general" data-toggle="tab">ATM Call</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="general">
                                        <div class="panel-body">
											<table class="table datatable-responsive datatable-button-html5-basic" style ='font-size: 11px'>
												<thead>
													<tr>
														<th>Status</th>
														<th>Ticket No</th>
														<th>Site</th>
														<th>ATM Name</th>
														<th>Description of Fault</th>
														<th>Logged By</th>
													</tr>
												</thead>
												<tbody>
													<?php
													//AND client_id=logged_by
														$sql = "SELECT * FROM atm_calls f,clients,atm_details, client_users WHERE client_id=f.client_id_fk AND atm_id=atm_id_fk AND client_user_id = logged_by AND f.client_id_fk=?;";
														$stmt = $object->connect()->prepare($sql);
														$stmt->bindvalue(1,$_SESSION['clientID']);
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
																elseif($rows['call_status'] == "Open Escalation"){$color = "label label-danger";}
																echo '
																	<tr>
																	<td><span class="label label-'. $color .'">'.$rows['call_status'].'</span></td>
																	<td><a href="ATMTicketDetails?atm_ticket_id='.$crypted_token.'">'.sprintf("%04d", $rows['call_id']).'</a></td>
																	<td>'.$rows['atm_site'].' ('.$rows['province'].')</td>
																	<td>'.$rows['atm_name'].'('.$rows['atm_type'].'/'.$rows['atm_model'].')</td>
																	<td>'.$rows['fault_details'].'</td>
																	<td>'.$rows['client_user_first_name'].' '.$rows['client_user_last_name'].'</td>
																	</tr>
																';
															}
															
															unset($token, $cipher_method, $enc_key, $enc_iv);
														}
														
													?>
												</tbody>
												<tfoot>
													<tr>
														<th>Status</th>
														<th>Ticket No</th>
														<th>Site</th>
														<th>ATM Name</th>
														<th>Description of Fault</th>
														<th>Logged By</th>
													</tr>
												</tfoot>
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
</body>
</html>
