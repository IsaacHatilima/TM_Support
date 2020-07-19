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
                                <h6 class="panel-title">Create Ticket</h6>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs nav-tabs-highlight">
                                            <li class="active"><a href="#general" data-toggle="tab">General Call</a></li>
                                            <li><a href="#delivery" data-toggle="tab">Delivery Call</a></li>
                                        </ul>

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="general">
                                                <div class="panel-body">
                                                    <form class="form-horizontal" id="general_call" action="" method="POST">
                                                        <div class="form-group">
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Priority:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <select class="select" data-placeholder="Select Priority" name="priority" id="priority" required="required">
                                                                    <option></option>
                                                                        <optgroup label="Priorities">
                                                                            <option value="Low">Low</option>
                                                                            <option value="Medium">Medium</option>
                                                                            <option value="High">High</option>
                                                                        </optgroup>
                                                                    </select>
                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Mechant Type:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <select data-placeholder="Select Mechant Type" name="mechtype" id="mechtype" class="select" required="required" onchange="getDeviceSerials(event)">
                                                                        <option></option>
                                                                        <optgroup label="Available Mechant Types">
                                                                            <option value="Retail">Retail</option>
                                                                            <option value="Forecourt">Forecourt</option>
                                                                        </optgroup>
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Device Serial:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <select data-placeholder="Select Device Serial" name="dev_serial" id="dev_serial" class="select-search" required="required">
                                                                        <option></option>
                                                                        
                                                                        </optgroup>
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Category:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <select data-placeholder="Select Category" name="cate" id="cate" class="select-search" required="required" onchange="getSubCate(event)">
                                                                        <option></option>
                                                                        <optgroup label="Available Category">
                                                                            <?php
                                                                                $sql = "SELECT * FROM pos_categories WHERE category_id != 5 ORDER BY category_id DESC;";
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
                                                                    <label class="col-md-4 control-label text-right">Sub Category:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <select data-placeholder="Select Sub Category" name="sub_cat" id="sub_cat" class="select-search" required="required">
                                                                        <option></option>
                                                                        
                                                                        </optgroup>
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Fault Description:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                        <textarea rows="3" cols="5" name="fault" id="fault"  class="form-control" placeholder="Fault Description" required="required"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Manager's Name:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="manager_name" id="manager_name" class="form-control"  placeholder="Enter Manager's Name" required="required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Manager's Cell Number:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" name="manager_cell" id="manager_cell" class="form-control"  placeholder="Enter Manager's Cell Number" required="required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Request User:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <select data-placeholder="Select Request User" name="requester" id="requester" class="select-search" required="required" >
                                                                        <option></option>
                                                                        <optgroup label="Request Users">
                                                                            <?php
                                                                                $sql = "SELECT * FROM client_users;";
                                                                                $stmt = $object->connect()->prepare($sql);
                                                                                $stmt->execute();
                                                                                while ($rows = $stmt->fetch())
                                                                                {
                                                                                    $id = $rows['client_user_id'];

                                                                                    $token = $id;

                                                                                    $cipher_method = 'aes-128-ctr';
                                                                                    $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);  
                                                                                    $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));  
                                                                                    $crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);

                                                                                    echo '<option value="'.$crypted_token.'">'.$rows['client_user_first_name'].' '.$rows['client_user_last_name'].'</option>';
                                                                                }
                                                                            ?>
                                                                        </optgroup>
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                            </div>                                           
                                                        </div>
                                                        <div class="text-right">
                                                            <button type="button" id='gencall' class="btn btn-primary">Save <i class="icon-floppy-disk position-left"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                                
                                            </div>
            
                                            <div class="tab-pane" id="delivery">
                                                <div class="panel-body">
                                                    <form class="form-horizontal" id="delivery_form_call" action="" method="POST">
                                                        <div class="form-group">
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Priority:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <select class="select" data-placeholder="Select Priority" name="delivery_priority" id="delivery_priority" required="required">
                                                                    <option></option>
                                                                        <optgroup label="Priorities">
                                                                            <option value="Low">Low</option>
                                                                            <option value="Medium">Medium</option>
                                                                            <option value="High">High</option>
                                                                        </optgroup>
                                                                    </select>
                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Mechant Type:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <select data-placeholder="Select Mechant Type" name="delivery_mechtype" id="delivery_mechtype" class="select" required="required" onchange="getMechants(event)">
                                                                        <option></option>
                                                                        <optgroup label="Available Mechant Types">
                                                                            <option value="Retail">Retail</option>
                                                                            <option value="Forecourt">Forecourt</option>
                                                                        </optgroup>
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Mechant ID:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <select data-placeholder="Mechant ID" name="mech_id" id="mech_id" class="select-search" required="required">
                                                                        <option></option>
                                                                        
                                                                        </optgroup>
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Category:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <select data-placeholder="Select Category" name="delivery_cate" id="delivery_cate" class="select-search" required="required" onchange="getDevSubCate(event)">
                                                                        <option></option>
                                                                        <optgroup label="Available Category">
                                                                            <?php
                                                                                $sql = "SELECT * FROM pos_categories WHERE category_id = 5 ORDER BY category_id DESC;";
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
                                                                    <label class="col-md-4 control-label text-right">Sub Category:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <select data-placeholder="Select Sub Category" name="delivery_sub_cat" id="delivery_sub_cat" class="select-search" required="required">
                                                                        <option></option>
                                                                        
                                                                        </optgroup>
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Item To Deliver:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                        <textarea rows="3" cols="5" name="item" id="item"  class="form-control" placeholder="Item To Deliver" required="required"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Manager's Name:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="delivery_manager_name" id="delivery_manager_name" class="form-control"  placeholder="Enter Manager's Name" required="required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Manager's Cell Number:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" name="delivery_manager_cell" id="delivery_manager_cell" class="form-control"  placeholder="Enter Manager's Cell Number" required="required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <label class="col-md-4 control-label text-right">Request User:<span class="text-danger">*</span> </label>
                                                                    <div class="col-md-8">
                                                                    <select data-placeholder="Select Request User" name="delivery_requester" id="delivery_requester" class="select-search" required="required" >
                                                                        <option></option>
                                                                        <optgroup label="Request Users">
                                                                            <?php
                                                                                $sql = "SELECT * FROM client_users;";
                                                                                $stmt = $object->connect()->prepare($sql);
                                                                                $stmt->execute();
                                                                                while ($rows = $stmt->fetch())
                                                                                {
                                                                                    $id = $rows['client_user_id'];

                                                                                    $token = $id;

                                                                                    $cipher_method = 'aes-128-ctr';
                                                                                    $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);  
                                                                                    $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));  
                                                                                    $crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);

                                                                                    echo '<option value="'.$crypted_token.'">'.$rows['client_user_first_name'].' '.$rows['client_user_last_name'].'</option>';
                                                                                }
                                                                            ?>
                                                                        </optgroup>
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                            </div>                                           
                                                        </div>
                                                        <div class="text-right">
                                                            <button type="button" id='delivery_call' class="btn btn-primary">Save <i class="icon-floppy-disk position-left"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>						
                    </div>
                    <div class="col-md-2"></div>
                </div>
			</div>
		</div>
	</div>
	<script src="../ajax/LogCalls.js"></script>
</body>
</html>
