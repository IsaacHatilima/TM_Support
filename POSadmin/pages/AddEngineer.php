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
						<h6 class="panel-title">Add Engineer</h6>
					</div>

	                <div class="panel-body">
	                	<form class="form-horizontal" id="engineers" action="" method="POST">
							<div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-4 control-label text-right">First Name:<span class="text-danger">*</span> </label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="EfirstName" id="EfirstName" placeholder="First Name" required="required">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-4 control-label text-right">Last Name:<span class="text-danger">*</span> </label>
                                            <div class="col-md-8">
                                                <input type="text" name="ElastName" id="ElastName" class="form-control" placeholder="Last Name" required="required">
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
                                                <input type="email" class="form-control" name="Eemail" id="Eemail" placeholder="Email" required="required">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-4 control-label text-right">Cell:<span class="text-danger">*</span> </label>
                                            <div class="col-md-8">
                                                <input type="tel" name="Ecell" id="Ecell" class="form-control" placeholder="Cell" required="required">
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

    <script src="../ajax/Engineers.js"></script>
</body>
</html>
