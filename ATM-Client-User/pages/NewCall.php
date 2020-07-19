<!DOCTYPE html>
<html lang="en">
<head>
	<?php include '../includes/header.php'; ?>
    <script type="text/javascript" src="../../assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="../../assets/js/pages/form_select2.js"></script>
</head>

<body class="navbar-bottom navbar-top">
	<?php include '../includes/topnav.php'; ?>
	<div class="page-container">
		<div class="page-content">
            <div id="lock-modal"></div>
            <div id="loading-circle"></div>
			<div class="content-wrapper">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 class="panel-title"><b>Create New Call</b></h3>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" id="prints" class="btn btn-primary pull-right" style="display:none"> <i class="icon-printer position-left"></i> Print Job Card</button>
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" id="new_call" action="" method="POST">
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">ATM Site: </label>
                                                <div class="col-md-8">
                                                    <select data-placeholder="Select ATM Site" name="atm_site" id="atm_site" class="select-search" required="required" onchange="getATMName(event)">
                                                        <option></option>
                                                        <optgroup label="ATM Sites">
                                                            <?php
                                                                $sql = "SELECT * FROM atm_details WHERE client_id_fk = ? GROUP BY atm_site;";
                                                                $stmt = $object->connect()->prepare($sql);
                                                                $stmt->bindvalue(1,$_SESSION['clientID']);
                                                                $stmt->execute();
                                                                while ($rows = $stmt->fetch())
                                                                {
                                                                    echo '<option value="'.$rows['atm_site'].'">'.$rows['atm_site'].'</option>';
                                                                }
                                                            ?>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>                                                
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">ATM Name: </label>
                                                <div class="col-md-8">
                                                    <select data-placeholder="Select ATM Name" name="atm_name" id="atm_name" class="select-search" required="required" >
                                                        <option></option>
                                                        <optgroup label="ATM Name">
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Category: </label>
                                                <div class="col-md-8">
                                                    <select data-placeholder="Select Category" name="category" id="category" class="select-search" required="required" onchange="getSubCate(event)">
                                                        <option></option>
                                                        <optgroup label="Categories">
                                                            <?php
                                                                $sql = "SELECT * FROM atm_categories;";
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
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Sub Category: </label>
                                                <div class="col-md-8">
                                                    <select data-placeholder="Select Sub Category" name="sub_category" id="sub_category" class="select-search" required="required" >
                                                        <option></option>
                                                        <optgroup label="Sub Category">
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Fault Description: </label>
                                                <div class="col-md-8">
                                                    <textarea rows="4" cols="5" name="fault" id="fault"  class="form-control" placeholder="Fault Description" required="required" ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Custodian's Name: </label>
                                                <div class="col-md-8">
                                                <input type="text" name="custodian_name" id="custodian_name" class="form-control"  placeholder="Enter Custodian's Name" required="required">
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="col-md-8">
                                            <div class="row">
                                                <label class="col-md-4 control-label text-right">Custodian's Number: </label>
                                                <div class="col-md-8">
                                                <input type="text" name="custodian_number" id="custodian_number" class="form-control"  placeholder="Enter Custodian's Name" required="required">
                                                </div>
                                            </div>
                                        </div>                                                                           
                                    </div>
                                    <div class="text-right">
                                        <button type="button" id='create_ticket' class="btn btn-success"><i class="icon-floppy-disk position-left"></i> Create</button>
                                    </div>

                                </form>
                            </div>
                        </div>						
                    </div>
                    <div class="col-md-2"></div>
                </div>
			</div>
		</div>
	</div>
	<script src="../ajax/NewCall.js"></script>
</body>
</html>
