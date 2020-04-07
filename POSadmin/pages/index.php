<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../includes/header.php'; ?>
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
						<h6 class="panel-title">Ticket Snipet</h6>
					</div>
					<!-- <div class="container-fluid"> -->
						<div class="row">
							<div class="col-lg-4">
								<ul class="list-inline text-center">
									<li>
										<span class="btn border-teal text-teal btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-plus3"></i></span>
									</li>
									<li class="text-left">
										<div class="text-semibold">New Calls</div>
										<?php
											$status = 'New';
											$sqle = "SELECT COUNT(pos_call_id) AS yanew FROM pos_calls WHERE call_status=?;";
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
										<span class="btn border-teal text-teal btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-notification2"></i></span>
									</li>
									<li class="text-left">
										<div class="text-semibold">Pending Calls</div>
										<?php
											$status = 'Open';
											$sqle = "SELECT COUNT(pos_call_id) AS yanew FROM pos_calls WHERE call_status=?;";
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
										<span  class="btn border-warning-400 text-warning-400 btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-watch2"></i></span>
									</li>
									<li class="text-left">
										<div class="text-semibold">Calls in Progress</div>
										<?php
											$status = 'In Progress';
											$sqle = "SELECT COUNT(pos_call_id) AS yanew FROM pos_calls WHERE call_status=?;";
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
						<h5 class="panel-title">Today's Calls</h5>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                		<li><a data-action="reload"></a></li>
		                	</ul>
	                	</div>
					</div>
                    <table class="table datatable-responsive">
						<thead>
							<tr>
								<th>Ticket No</th>
								<th>Mechant</th>
								<th>Location</th>
								<th>Device Type</th>
								<th>Logged By</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
							//AND client_id=logged_by
								$sql = "SELECT * FROM mechants,pos_calls,clients where mechant_type=mechant_id  AND call_status != 'Closed' ORDER BY pos_call_id DESC LIMIT 10;";
								$stmt = $object->connect()->prepare($sql);
								$stmt->execute();
								if($stmt->rowCount())
								{
									while ($rows = $stmt->fetch())
									{
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
											<td>'.$rows['site_location'].'</td>
											<td>'.$rows['device_type'].'</td>
											<td>'.$rows['client_first_name'].' '.$rows['client_last_name'].'</td>
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
					['x', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],

					['Retail', <?php echo $Rjan['Rjan']; ?>, <?php echo $Rfeb['Rfeb']; ?>, <?php echo $Rmar['Rmar']; ?>, <?php echo $Rapr['Rapr']; ?>, <?php echo $Rmay['Rmay']; ?>, <?php echo $Rjun['Rjun']; ?>, <?php echo $Rjul['Rjul']; ?>, <?php echo $Raug['Raug']; ?>, <?php echo $Rsep['Rsep']; ?>, <?php echo $Roct['Roct']; ?>, <?php echo $Rnov['Rnov']; ?>, <?php echo $Rdec['Rdec']; ?>],

					['Forecourt', <?php echo $Fjan['Fjan']; ?>, <?php echo $Ffeb['Ffeb']; ?>, <?php echo $Fmar['Fmar']; ?>, <?php echo $Fapr['Fapr']; ?>, <?php echo $Fmay['Fmay']; ?>, <?php echo $Fjun['Fjun']; ?>, <?php echo $Fjul['Fjul']; ?>, <?php echo $Faug['Faug']; ?>, <?php echo $Fsep['Fsep']; ?>, <?php echo $Foct['Foct']; ?>, <?php echo $Fnov['Fnov']; ?>, <?php echo $Fdec['Fdec']; ?>]
				],
				type: 'bar',
				colors: {
					Retail: '#00BCD4',
					Forecourt: 'red'
				}
			},
			
			axis: {
				x: {
					type: 'category',
					tick: {
						rotate: -90
					},
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
