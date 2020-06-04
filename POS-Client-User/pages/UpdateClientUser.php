<!DOCTYPE html>
<html lang="en">
<head>
	<?php include '../includes/header.php'; ?>
	<script type="text/javascript" src="../../assets/js/plugins/forms/selects/select2.min.js"></script>
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
                                <h6 class="panel-title">Update Bank</h6>
                            </div>

                            <div class="panel-body">
                                <form class="form-horizontal" id="clients" action="" method="POST">
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
                                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required="required" readonly="readonly">
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
                                                    <label class="col-md-4 control-label text-right">Bank:<span class="text-danger">*</span> </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="bankName" id="bankName" class="form-control" placeholder="Bank Name" readonly="readonly">
                                                        
                                                        <input type="hidden" name="personID" id="personID" value="<?php echo $_GET['personId'] ?>" readonly="readonly" required="required" >
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
                                                            <option value="Primary">Primary</option>
                                                            <option value="Secondary">Secondary</option>
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="text-right">
                                        <button type="button" id='update' class="btn btn-primary">Save <i class="icon-floppy-disk position-right"></i></button>
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
	<div id="lock-modal"></div>
    <div id="loading-circle"></div>
	<script src="../ajax/UserMGT.js"></script>
    <script>
        $(document).ready(function(){
            event.preventDefault();
            $("#lock-modal").css("display", "block");
            $("#loading-circle").css("display", "block");
            var ex = document.getElementById("personID").value;
            $.ajax({
                type: "post",
                url: "../core/UserMGT.php",
                data: {"geting" : ex},
                success: function(strMessage) {
                    console.log(strMessage);
                    var xx = strMessage;
                    if (xx != 'Failed' || xx != 'Error') {
                        var obj = JSON.parse(strMessage);
                        $('#firstName').val(obj.fname);
                        $('#lastName').val(obj.lname);
                        $('#email').val(obj.email);
                        $('#cell').val(obj.cell);
                        $('#bankName').val(obj.bankname);
                        $("#lock-modal").css("display", "none");
                        $("#loading-circle").css("display", "none");
                    }
                    if (xx == 'Failed') {    
                        iziToast.show({
                            title: 'Warning!',
                            message: 'Failed to User Details. Please Try Again.',
                            color: 'yello',
                            position: 'topRight',
                            icon: 'fa fa-check',
                            timeout: 2000
                        });    
                        $("#lock-modal").css("display", "none");
                        $("#loading-circle").css("display", "none");
                    }
                    if (xx == 'Error') {    
                        iziToast.show({
                            title: 'Error!',
                            message: 'An Error Occured. Please Try Again.',
                            color: 'red',
                            position: 'topRight',
                            icon: 'fa fa-check',
                            timeout: 2000
                        });    
                        $("#lock-modal").css("display", "none");
                        $("#loading-circle").css("display", "none");
                    }
                }
            });
        });

        $(document).ready(function()
        {
            event.preventDefault();
            var val = document.getElementById("personID").value;
            $("#lock-modal").css("display", "block");
            $("#loading-circle").css("display", "block");
            $.ajax({
                type: "POST",
                url: "../core/UserMGT.php",
                data: { 'conBank2': val },
                dataType: "html",
                success: function(strMessage) {
                    console.log(strMessage);
                    $('#cont_type').prepend(strMessage);
                    $("#lock-modal").css("display", "none");
                    $("#loading-circle").css("display", "none");
                }
            });
        });
    </script>
</body>
</html>
