
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include '../includes/header.php'; ?>
    <script type="text/javascript" src="../../assets/js/pages/form_select2.js"></script>
    <script type="text/javascript" src="../../assets/js/core/libraries/jquery_ui/interactions.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/selects/select2.min.js"></script>
</head>

<body class="navbar-bottom navbar-top">
	<?php include '../includes/topnav.php'; ?>


	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="panel panel-flat">
                            <div class="panel panel-flat">
                                <div class="panel-heading">
                                    <h6 class="panel-title">Add Client</h6>
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
                                            <button type="button" id='saver' class="btn btn-primary">Save <i class="icon-floppy-disk position-right"></i></button>
                                        </div>
                                    </form>
                                </div>
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
</body>
</html>
