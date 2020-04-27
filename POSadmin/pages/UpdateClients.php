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
                                <h6 class="panel-title">Update Bank</h6>
                            </div>

                            <div class="panel-body">
                                <form class="form-horizontal" id="benks" action="" method="POST">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Client Name:<span class="text-danger">*</span> </label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="bankName" id="bankName" placeholder="Client Name" required="required">
                                                        <input type="hidden" readonly class="form-control" name="bankID" id="bankID" value="<?php echo $_GET['id']  ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row">
                                                    <label class="col-md-4 control-label text-right">Client Name Abbri: </label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="bankNameAbb" id="bankNameAbb" class="form-control" placeholder="Client Name Abbriviation">
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
                    <div class="col-md-2"></div>
                </div>
			</div>
		</div>
	</div>
	<div id="lock-modal"></div>
    <div id="loading-circle"></div>
	<script src="../ajax/Banks.js"></script>
    <script>
        $(document).ready(function(){
            event.preventDefault();
            $("#lock-modal").css("display", "block");
            $("#loading-circle").css("display", "block");
            var ex = document.getElementById("bankID").value;
            $.ajax({
                type: "post",
                url: "../core/CoreAddClient.php",
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
</body>
</html>
