
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

    <div id="lock-modal"></div>
    <div id="loading-circle"></div>
	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">

				<div class="panel panel-flat">
					<div class="panel-heading">
						<h5 class="panel-title">Client Engineers</h5>
					</div>

                    <table class="table datatable-responsive datatable-button-html5-basic">
						<thead>
							<tr>
								<th>Full Name</th>
								<th>Email</th>
								<th>Cell</th>
								<th>Department</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$sql = "SELECT * FROM engineers WHERE department = 'POS Engineer';";
								$stmt = $object->connect()->prepare($sql);
								$stmt->execute();
								if($stmt->rowCount())
								{
									while ($rows = $stmt->fetch())
									{
										$id = $rows['engineer_id'];

										$token = $id;

										$cipher_method = 'AES-256-CTR';
										$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);  
										$enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));  
										$crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
									
										echo '
											<tr>
											<td>'.$rows['engineer_first_name'].' '.$rows['engineer_last_name'].'</td>
                                            <td>'.$rows['email'].'</td>
                                            <td>'.$rows['cell'].'</td>
                                            <td>'.$rows['department'].'</td>
                                            <td>
                                            <a href="UpdateEngineer?personId='.$crypted_token.'" style ="font-size: 11px;" class="btn btn-info btn-rounded btn-xs"><i class="icon-pen "></i> Update</a>

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
	<script src="../ajax/Engineers.js"></script>
</body>
</html>
