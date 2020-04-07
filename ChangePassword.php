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
    <style>
        #pswd_info {
            /* position:absolute; */
            bottom:-75px;
            bottom: -115px\9; /* IE Specific */
            width:100%;
            padding:15px;
            background:#fefefe;
            font-size:.875em;
            border-radius:5px;
            box-shadow:0 1px 3px #ccc;
            border:1px solid #ddd;
        }
        #pswd_info h4 {
            margin:0 0 10px 0;
            padding:0;
            font-weight:normal;
        }
        #pswd_info::before {
            /* content: "\25B2"; */
            /* position:absolute; */
            top:-12px;
            left:45%;
            font-size:14px;
            line-height:14px;
            color:#ddd;
            text-shadow:none;
            display:block;
        }
        .invalid {
            /* background:url(../images/invalid.png) no-repeat 0 50%; */
            padding-left:22px;
            line-height:24px;
            color:#ec3f41;
        }
        .valid {
            /* background:url(../images/valid.png) no-repeat 0 50%; */
            padding-left:22px;
            line-height:24px;
            color:#3a7d34;
        }
    </style>

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
							<div class="alert alert-warning  alert-styled-right" id="notif6" style="display:none;">
								Passwords Don't Match. Try Again.
							</div>
							<div class="alert alert-danger  alert-styled-right" id="notif4" style="display:none;">
								An Error Occured. Please Try Again.
							</div>
							<div class="alert alert-success  alert-styled-right" id="notif5" style="display:none;">
								Authenticated, Redirecting..
							</div>
                            <div class="alert alert-warning  alert-styled-right" id="notif3" style="display:none;">
								Invalid Current Password.
							</div>
							<h5 class="content-group-lg">Change Password To Proceed</h5>
						</div>
						<div class="form-group has-feedback has-feedback-left">
							<input type="password" class="form-control" placeholder="Current Password" name="OGpassword" id="OGpassword"  required="required">
							<div class="form-control-feedback">
								<i class="icon-lock2 text-muted"></i>
							</div>
						</div>
                        <div class="form-group has-feedback has-feedback-left">
							<input type="password" class="form-control" placeholder="New Password" name="newpassword" id="newpassword"  required="required">
							<div class="form-control-feedback">
								<i class="icon-lock2 text-muted"></i>
							</div>
						</div>
						<div class="form-group has-feedback has-feedback-left">
							<input type="password" class="form-control" placeholder="Confirm Password" name="conpassword" id="conpassword"  required="required">
							<div class="form-control-feedback">
								<i class="icon-lock2 text-muted"></i>
							</div>
						</div>
						<div class="form-group">
							<button type="button" id='change' class="btn bg-blue btn-block">Go <i class="icon-spinner2 spinner position-right" id="spinner" style="display:none;"></i><i class="icon-arrow-right14 position-right" id="arrow"></i></button>
						</div>

                        <div id="pswd_info">
                            <h4>Password must meet the following requirements:</h4>
                            <ul>
                                <li id="letter" class="invalid">At least <strong>one letter</strong></li>
                                <li id="capital" class="invalid">At least <strong>one capital letter</strong></li>
                                <li id="number" class="invalid">At least <strong>one number</strong></li>
                                <li id="length" class="invalid">Be at least <strong>8 characters</strong></li>
                            </ul>
                        </div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="access/ajax/Go.js"></script>

</body>
</html>
