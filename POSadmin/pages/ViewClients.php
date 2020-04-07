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
						<h5 class="panel-title">Client Users</h5>
					</div>

                    <table class="table datatable-responsive datatable-button-html5-basic">
						<thead>
							<tr>
								<th>Full Name</th>
								<th>Email</th>
								<th>Cell</th>
								<th>Bank</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$sql = "SELECT * FROM clients,banks WHERE bank_id = bank_id_fk;";
								$stmt = $object->connect()->prepare($sql);
								$stmt->execute();
								if($stmt->rowCount())
								{
									while ($rows = $stmt->fetch())
									{
										$id = $rows['client_id'];

										$token = $id;

										$cipher_method = 'aes-128-ctr';
										$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);  
										$enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));  
										$crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
									
										echo '
											<tr>
											<td>'.$rows['client_first_name'].' '.$rows['client_last_name'].'</td>
                                            <td>'.$rows['email'].'</td>
                                            <td>'.$rows['cell'].'</td>
                                            <td>'.$rows['bank_name'].'</td>
                                            <td>
                                            <a href="UpdateClientUser?personId='.$crypted_token.'" style ="font-size: 11px;" class="btn btn-info btn-rounded btn-xs"><i class="icon-pen "></i> Update</a>

                                            <button type="button" style ="font-size: 11px;" class="btn btn-danger btn-rounded btn-xs" value="'.$crypted_token.'" onclick="Deletes(this.value);"><i class="icon-trash "></i> Delete</button>



                                            </td>
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
	<div id="lock-modal"></div>
    <div id="loading-circle"></div>
    <script src="../ajax/UserMGT.js"></script>
</body>
</html>
