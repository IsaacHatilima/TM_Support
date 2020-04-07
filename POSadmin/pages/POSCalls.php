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
						<h5 class="panel-title">All Calls</h5>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                		<li><a data-action="reload"></a></li>
		                	</ul>
	                	</div>
					</div>

                    <table class="table datatable-responsive datatable-button-html5-basic" style ='font-size: 11px'>
						<thead>
							<tr>
								<th>Ticket No</th>
								<th>Mechant Type</th>
								<th>Mechant Name</th>
								<th>Location</th>
								<th>Device Type</th>
								<th>Category</th>
								<th>Sub Category</th>
								<th>Third Level Category</th>
								<th>Description of Fault</th>
								<th>Solution</th>
								<th>Time to Repair</th>
								<th>Time Logged</th>
								<th>Time Closed</th>
								<th>Logged By</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
							//AND client_id=logged_by
								$sql = "SELECT * FROM mechants,pos_calls p,pos_categories, pos_sub_categories where mechant_type=mechant_id  AND p.category_id_fk = category_id AND sub_category_id_fk = sub_category_id ORDER BY pos_call_id DESC;";
								$stmt = $object->connect()->prepare($sql);
								$stmt->execute();
								if($stmt->rowCount())
								{
									while ($rows = $stmt->fetch())
									{
										$sql2 = "SELECT client_first_name,client_last_name FROM clients WHERE client_id=?;";
										$statement = $object->connect()->prepare($sql2);
										$statement-> bindvalue(1,$rows['logged_by']);
										$statement->execute();
										$row = $statement->fetch();

										$id = $rows['pos_call_id'];

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
											<td><a href="POSTicketDetails?pos_ticket_id='.$crypted_token.'">TMSP'.$rows['pos_call_id'].'</a></td>
											<td>'.$rows['mechants'].'</td>
											<td>'.$rows['mechant_name'].'</td>
											<td>'.$rows['site_location'].'</td>
											<td>'.$rows['device_type'].'</td>
											<td>'.$rows['category'].'</td>
											<td>'.$rows['sub_category'].'</td>
											<td>'.$rows['third_level_category'].'</td>
											<td>'.$rows['fault_details'].'</td>
											<td>'.$rows['solution'].'</td>
											<td>'.$rows['repair_time'].'</td>
											<td>'.$rows['date_logged'].' '.$rows['time_logged'].'</td>
											<td>'.$rows['date_closed'].' '.$rows['time_closed'].'</td>
											<td>'.$row['client_first_name'].' '.$row['client_last_name'].'</td>
											<td><span class="label label-'. $color .'">'.$rows['call_status'].'</span></td>
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
</body>
</html>
