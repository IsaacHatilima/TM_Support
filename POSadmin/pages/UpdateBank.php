<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../includes/header.php'; ?>

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
						<h6 class="panel-title">Update Bank</h6>
					</div>

	                <div class="panel-body">
	                	<form class="form-horizontal" id="benks" action="" method="POST">
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-4 control-label text-right">Bank Name:<span class="text-danger">*</span> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="bankName" id="bankName" placeholder="Bank Name" required="required">
                                                <input type="hidden" readonly class="form-control" name="bankID" id="bankID" value="<?php echo $_GET['id']  ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-4 control-label text-right">Bank Name Abbri:<span class="text-danger">*</span> </label>
                                            <div class="col-md-8">
                                                <input type="text" name="bankNameAbb" id="bankNameAbb" class="form-control" placeholder="Bank Name Abbriviation" required="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

	                        <div class="text-right">
	                        	<button type="button" id='updatebtn' class="btn btn-primary">Save <i class="icon-floppy-disk position-right"></i></button>
	                        </div>
                        </form>
				    </div>
				</div>
			</div>
		</div>
	</div>
	<div id="lock-modal"></div>
    <div id="loading-circle"></div>
    <script>
        $(document).ready(function(){
            event.preventDefault();
            $("#lock-modal").css("display", "block");
            $("#loading-circle").css("display", "block");
            var ex = document.getElementById("bankID").value;
            $.ajax({
                type: "post",
                url: "../core/CoreAddBank.php",
                data: {"geting" : ex},
                success: function(strMessage) {
                    console.log(strMessage);
                    var xx = strMessage;
                    if (xx != 'Failed' || xx != 'Error') {
                        var obj = JSON.parse(strMessage);
                        $('#bankName').val(obj.bankname);
                        $('#bankNameAbb').val(obj.bankabbs);
                        $("#lock-modal").css("display", "none");
                        $("#loading-circle").css("display", "none");
                    }
                    if (xx == 'Failed') {    
                        iziToast.show({
                            title: 'Warning!',
                            message: 'Failed to Fetch Bank Details. Please Try Again.',
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
    </script>
    <script src="../ajax/Banks.js"></script>
</body>
</html>
