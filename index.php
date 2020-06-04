<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="assets/images/Logo.jpg">
	<title>TechMasters Support System</title>

	<!-- Global stylesheets -->
	<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css"> Logo.jpg-->
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>

	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/login.js"></script>

	<script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
	<!-- /theme JS files -->

</head>
<body class="login-container">
	<div class="page-container pb-20">
		<div class="page-content">
			<div class="content-wrapper">
				<form action="" method="post" id="signin">
					<div class="panel panel-body login-form">
						<div class="text-center">
							<div class="alert alert-warning  alert-styled-right" id="notif1" style="display:none;">
								<span style="font-size:11px">All Fields Are Required.</span>
							</div>
							<div class="alert alert-info  alert-styled-right" id="notif2" style="display:none;">
								Authenticating, Please wait....
							</div>
							<div class="alert alert-warning  alert-styled-right" id="notif3" style="display:none;">
								Invalid Email or Password. Try Again.
							</div>
							<div class="alert alert-danger  alert-styled-right" id="notif4" style="display:none;">
								An Error Occured. Please Try Again.
							</div>
							<div class="alert alert-success  alert-styled-right" id="notif5" style="display:none;">
								Authenticated, Redirecting..
							</div>
							<div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
							<h5 class="content-group-lg">Login to your account <small class="display-block">Enter your credentials</small></h5>
						</div>
						<div class="form-group has-feedback has-feedback-left">
							<input type="email" class="form-control" placeholder="Email" name="email" id="email"  required="required">
							<div class="form-control-feedback">
								<i class="icon-user text-muted"></i>
							</div>
						</div>
						<div class="form-group has-feedback has-feedback-left">
							<input type="password" class="form-control" placeholder="Password" name="password" id="password"  required="required">
							<div class="form-control-feedback">
								<i class="icon-lock2 text-muted"></i>
							</div>
						</div>
						<div class="form-group login-options">
							<div class="row">
								<div class="col-sm-6">
								</div>
								<div class="col-sm-6 text-right">
									<a href="ForgotPassword">Forgot password?</a>
								</div>
							</div>
						</div> 
						<div class="form-group">
							<button type="button" id='login' class="btn bg-blue btn-block">Login <i class="icon-spinner2 spinner position-right" id="spinner" style="display:none;"></i><i class="icon-arrow-right14 position-right" id="arrow"></i></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="navbar navbar-default navbar-fixed-bottom footer">
		<ul class="nav navbar-nav visible-xs-block">
			<li><a class="text-center collapsed" data-toggle="collapse" data-target="#footer"><i class="icon-circle-up2"></i></a></li>
		</ul>

		<div class="navbar-collapse collapse" id="footer">
			<div class="navbar-text">
				&copy; <?php echo date('Y'); ?>. <a href="https://www.techmasters.co.zm" target="_blank" class="navbar-link">TechMasters Support System</a>
			</div>

			<div class="navbar-right">
				<ul class="nav navbar-nav">
					<li><a href="https://www.techmasters.co.zm/about">About</a></li>
					<li><a  data-toggle="modal" data-target="#modal_backdrop">Contact</a></li>
				</ul>
			</div>
            <div id="modal_backdrop" class="modal fade" data-backdrop="false">
                <div class="modal-dialog modal-xs">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h5 class="modal-title">For System Queries</h5>
                        </div>

                        <div class="modal-body">
                            <p><b>For all system queries contact Isaac on:</b></p>
                            <p>Email: isaac@techmasters.co.zm</p>
                            <p>Cell: +260977477311</p>

                            <hr>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
	<script src="access/ajax/Go.js"></script>

</body>
</html>
