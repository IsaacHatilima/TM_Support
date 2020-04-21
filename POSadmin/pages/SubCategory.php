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
						<div class="row">
							<div class="col-md-6">
								<h5 >POS Sub Categories</h5>
							</div>
							<div class="col-md-6">
								<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_default"><i class="icon-plus3 position-left"></i> Add Sub-Category</button>
							</div>
						</div>
						<div id="modal_default" class="modal fade" data-backdrop="static">
							<div class="modal-dialog">
								<div class="modal-content">
									<form class="form-horizontal" id="subcats" action="" method="POST">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h5 class="modal-title">Add Sub Category</h5>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<div class="col-md-12">
													<div class="row">
														<label class="col-md-4 control-label text-right">Category:<span class="text-danger">*</span> </label>
														<div class="col-md-8">
														<select data-placeholder="Select Category" name="catego" id="catego" class="select-search" required="required">
															<option></option>
															<optgroup label="Available Categories">
																<?php
																	$sql = "SELECT * FROM pos_categories ORDER BY category_id DESC;";
																	$stmt = $object->connect()->prepare($sql);
																	$stmt->execute();
																	while ($rows = $stmt->fetch())
																	{
																		$id = $rows['category_id'];

																		$token = $id;

																		$cipher_method = 'aes-128-ctr';
																		$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);  
																		$enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));  
																		$crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);

																		echo '<option value="'.$crypted_token.'">'.$rows['category'].'</option>';
																	}
																?>
															</optgroup>
														</select>
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="row">
														<label class="col-md-4 control-label text-right">Sub-Category:<span class="text-danger">*</span> </label>
														<div class="col-md-8">
															<input type="text" class="form-control" name="subcateg" id="subcateg" placeholder="Sub-Category" required="required">
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
								<th>Category</th>
								<th>Sub-Category</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$sql = "SELECT * FROM pos_categories, pos_sub_categories WHERE category_id=category_id_fk ORDER BY category_id DESC;";
								$stmt = $object->connect()->prepare($sql);
								$stmt->execute();
								if($stmt->rowCount())
								{
									while ($rows = $stmt->fetch())
									{
										$id = $rows['sub_category_id'];

										$token = $id;

										$cipher_method = 'aes-128-ctr';
										$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);  
										$enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));  
										$crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
									
										echo '
											<tr>
											<td>'.$rows['category'].'</td>
											<td>'.$rows['sub_category'].'</td>
                                            <td>

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
    <script src="../ajax/SubCategory.js"></script>
</body>
</html>
