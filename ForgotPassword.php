
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="assets/images/Logo.jpg">
	<title>TechMasters Support System</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
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
	<script type="text/javascript" src="assets/js/core/app.js"></script>

	<script type="text/javascript" src="assets/js/plugins/ui/ripple.min.js"></script>
	<!-- /theme JS files -->

</head>

<body class="navbar-bottom login-container">



	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
				<form action="" action="POST" id=resets>
					<div class="panel panel-body login-form">
                        <div class="alert alert-warning  alert-styled-right" id="notif1" style="display:none;">
                            <span >Email Required.</span>
                        </div>
                        <div class="alert alert-info  alert-styled-right" id="notif2" style="display:none;">
                            Processing, Please wait....
                        </div>
                        <div class="alert alert-danger  alert-styled-right" id="notif3" style="display:none;">
								An Error Occured. Please Try Again.
							</div>
						<div class="text-center">
							<div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
							<h5 class="content-group">Password recovery <small class="display-block">We'll send you an email with instructions</small></h5>
						</div>

						<div class="form-group has-feedback">
							<input type="email" class="form-control" name="emailz" id="emailz" placeholder="Your email">
							<div class="form-control-feedback">
								<i class="icon-mail5 text-muted"></i>
							</div>
						</div>

						<button type="button" id="reset" class="btn bg-blue btn-block">Reset password <i class="icon-spinner2 spinner position-right" id="spinner" style="display:none;"></i><i class="icon-arrow-right14 position-right" id="arrow"></i></button>
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
