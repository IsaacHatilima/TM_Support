<!DOCTYPE html>
<html lang="en">
<head>
	<?php include '../includes/header.php'; ?>
	<script type="text/javascript" src="../../assets/js/plugins/forms/selects/select2.min.js"></script>
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
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<div class="row">
									<div class="col-md-6">
										<h5 >POS Categories</h5>
									</div>
									<div class="col-md-6">
										<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_default"><i class="icon-plus3 position-left"></i> Add Category</button>
									</div>
								</div>
								<div id="modal_default" class="modal fade" data-backdrop="static">
									<div class="modal-dialog">
										<div class="modal-content">
											<form class="form-horizontal" id="cats" action="" method="POST">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h5 class="modal-title">Add Category</h5>
												</div>
												<div class="modal-body">
													<div class="form-group">
															<div class="col-md-12">
																<div class="row">
																	<label class="col-md-4 control-label text-right">Category:<span class="text-danger">*</span> </label>
																	<div class="col-md-8">
																		<input type="text" class="form-control" name="categ" id="categ" placeholder="Category" required="required">
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
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$sql = "SELECT * FROM pos_categories ORDER BY category_id DESC;";
										$stmt = $object->connect()->prepare($sql);
										$stmt->execute();
										if($stmt->rowCount())
										{
											while ($rows = $stmt->fetch())
											{
												$id = $rows['category_id'];

												$token = $id;

												$cipher_method = 'aes-128-ctr';
												$enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);  
												$enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));  
												$crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
											
												echo '
													<tr>
													<td>'.$rows['category'].'</td>
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
                    <div class="col-md-2"></div>
                </div>
			</div>
		</div>
	</div>
	<div id="lock-modal"></div>
    <div id="loading-circle"></div>
	<script src="../ajax/Categories.js"></script>
</body>
</html>
