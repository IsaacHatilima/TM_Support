<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../includes/header.php'; ?>
    <script type="text/javascript" src="../../assets/js/pages/form_select2.js"></script>
    <script type="text/javascript" src="../../assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/selects/select2.min.js"></script>

</head>

<body class="navbar-bottom">
    <?php include '../includes/topnav.php'; ?>
	<!-- Page container -->
    <div id="lock-modal"></div>
    <div id="loading-circle"></div>
	<div class="page-container" >

		<!-- Page content -->
		<div class="page-content">

            <?php include '../includes/sidenav.php'; ?>
			<!-- Main content -->
			<div class="content-wrapper">
                <div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title">Add Client User</h6>
					</div>

	                <div class="panel-body">
	                	<form class="form-horizontal" id="clientsForm" action="" method="POST">
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-4 control-label text-right">First Name:<span class="text-danger">*</span> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="firstName" id="firstName" placeholder="First Name" required="required">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-4 control-label text-right">Last Name:<span class="text-danger">*</span> </label>
                                            <div class="col-md-8">
                                                <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Last Name" required="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-4 control-label text-right">Email:<span class="text-danger">*</span> </label>
                                            <div class="col-md-8">
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required="required">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-4 control-label text-right">Cell:<span class="text-danger">*</span> </label>
                                            <div class="col-md-8">
                                                <input type="tel" name="cell" id="cell" class="form-control" placeholder="Cell" required="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-4 control-label text-right">Client:<span class="text-danger">*</span> </label>
                                            <div class="col-lg-8">
                                                <select data-placeholder="Select Client" name="bankName" id="bankName" class="select" required="required" onchange="getContact(event)">
                                                    <option></option>
                                                    <optgroup label="Available Clients">
                                                        <?php
                                                            $sql = "SELECT * FROM clients ORDER BY client_id DESC;";
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

                                                                echo '<option value="'.$crypted_token.'">'.$rows['client_name'].' ('.$rows['client_name_abbr'].')</option>';
                                                            }
                                                        ?>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-4 control-label text-right">Contact Type:<span class="text-danger">*</span> </label>
                                            <div class="col-lg-8">
                                                <select data-placeholder="Select Contact Type" name="cont_type" id="cont_type" class="select" required="required">
                                                    <option></option>
                                                    <optgroup label="Available Contact Types">
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

	                        <div class="text-right">
	                        	<button type="button" id='saver' class="btn btn-primary">Save <i class="icon-floppy-disk position-right"></i></button>
	                        </div>
                        </form>
				    </div>
				</div>
			</div>
		</div>
	</div>
    <script src="../ajax/UserMGT.js"></script>
</body>
</html>
