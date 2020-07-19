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
	<div class="page-container">
		<div class="page-content">
            <div id="lock-modal"></div>
            <div id="loading-circle"></div>
			<div class="content-wrapper">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
						<div class="panel panel-flat">
								<div class="panel panel-flat">
							<div class="panel-heading">
								<div class="row">
									<div class="col-md-6">
										<h5 >SLA Times</h5>
									</div>
									<div class="col-md-6">
										<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_default"><i class="icon-plus3 position-left"></i> Add Device</button>
									</div>
								</div>
								<div id="modal_default" class="modal fade " data-backdrop="static" style="margin-top:50px;">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<form class="form-horizontal" id="sla" action="" method="POST">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h5 class="modal-title">Add SLA Times</h5>
												</div>
												<div class="modal-body">
													<div class="form-group">
														<div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <label class="col-md-4 control-label text-right">Client:<span class="text-danger">*</span> </label>
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <legend class="text-bold">Week Days (Monday to Friday)</legend>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Start:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <input class="form-control" type="time" name="start_time"  id="start_time" required="required">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">End:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <input class="form-control" type="time" name="end_time" id="end_time" required="required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                       
                                                    </div>
                                                    <legend class="text-bold">Weekends and Holidays</legend>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Start:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <input class="form-control" type="time" name="wik_start_time" id="wik_start_time" required="required">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">End:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <input class="form-control" type="time" name="wik_end_time" id="wik_end_time" required="required">
                                                                    </div>
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
										<th>Client</th>
										<th>Time Period</th>
										<th>Start Time</th>
										<th>End Time</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$sql = "SELECT * FROM atm_sla, clients WHERE client_id = client_sla_for;";
										$stmt = $object->connect()->prepare($sql);
										$stmt->execute();
										if($stmt->rowCount())
										{
											while ($rows = $stmt->fetch())
											{
												$id = $rows['sla_id'];

												$token = $id;

												$cipher_method = 'aes-128-ctr';
												$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);  
												$enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));  
												$crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
											
												echo '
													<tr>
													<td>'.$rows['client_name'].' ('.$rows['client_name_abbr'].')</td>
													<td>'.$rows['time_period'].'</td>
													<td>'.$rows['start_time'].'</td>
													<td>'.$rows['end_time'].'</td>

													<td>

													<a href="UpdateSLA?sla_id='.$crypted_token.'" style ="font-size: 11px;" class="btn btn-warning btn-rounded btn-xs"><i class="icon-pen "></i> </a>

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
                                        <th>Client</th>
										<th>Time Period</th>
										<th>Start Time</th>
										<th>End Time</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>
						</div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
			</div>
		</div>
	</div>
	<script src="../ajax/SLA.js"></script>
</body>
</html>
