	<?php
		ob_start();
		session_start();
		if($_SESSION['person'] == null)
		{
			header('Location: ../../');
		}
		require_once('../../config/db.php');
		$object = new Database();
		$object->connect();

		$sqlClients = "SELECT * FROM engineers WHERE engineer_id =?;";
		$stmtClients = $object->connect()->prepare($sqlClients);
		$stmtClients->bindvalue(1, $_SESSION['person']);
		$stmtClients->execute();
		$stmtClients->rowCount();
		$rows = $stmtClients->fetch();
		$firstName = $rows['engineer_first_name'];
		$lastName = $rows['engineer_last_name'];
	?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../assets/images/Logo.jpg">
	<title>TechMasters Support System</title>

	<!-- Global stylesheets _sidebar_sticky_custom.js:122 Uncaught TypeError: Cannot read property -->
	<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css"> -->
	<link href="../../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="../../assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="../../assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="../../assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="../../assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="../../assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="../../assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="../../assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files  sticky_native.js:77 Uncaught TypeError: Cannot read property -->
	<script type="text/javascript" src="../../assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/pickers/daterangepicker.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/ui/nicescroll.min.js"></script>

	<script type="text/javascript" src="../../assets/js/plugins/ui/prism.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/buttons/hover_dropdown.min.js"></script>
	


	<script type="text/javascript" src="../../assets/js/core/app.js"></script>
	<!-- <script type="text/javascript" src="../../assets/js/pages/layout_sidebar_sticky_native.js"></script> -->

	<!-- /theme JS files -->
	<script type="text/javascript" src="../../assets/js/plugins/visualization/c3/c3.min.js"></script>
  	<script type="text/javascript" src="../../assets/js/charts/c3/c3_advanced.js"></script>
  	<script type="text/javascript" src="../../assets/js/charts/c3/c3_axis.js"></script>
	  <script type="text/javascript" src="../../assets/js/pages/form_inputs.js"></script>

    <link rel="stylesheet" href="../../iziToast/dist/css/iziToast.min.css">
    <script src="../../iziToast/dist/js/iziToast.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/notifications/bootbox.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/notifications/sweet_alert.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/validation/validate.min.js"></script>

	<script type="text/javascript" src="../../assets/js/core/libraries/jasny_bootstrap.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/inputs/autosize.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/inputs/formatter.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/inputs/typeahead/handlebars.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/inputs/passy.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/inputs/maxlength.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/ui/nicescroll.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/ui/drilldown.js"></script>

	<!-- charts -->
	<!-- <script type="text/javascript" src="../../assets/js/charts/c3/c3_bars_pies.js"></script> -->

	<script type="text/javascript" src="../../assets/js/plugins/ui/ripple.min.js"></script>
	
	 
	  
	<style>
		body{
			overflow: auto;
			height: 100px;
			font-size: 12px;
		}
		

		#lock-modal {
			background-color: black;
			opacity: 0.6;
			position: absolute;
  			height: 100%;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			z-index: 9999;
			border-radius: inherit;
			display:none;
		}
		#loading-circle{
			position: absolute;
			top: 50px;
			bottom: 0;
			z-index: 9999;
			left: 0;
			right: 0;
			margin: auto;
			width: 40px;
			height: 40px;
			border: 4px solid #f3f3f3;
			border-top: 4px solid #3498db;
			border-radius: 50%;
			animation: spin 0.6s ease-in infinite;
			display:none;
		}
		@keyframes spin{
			0%{
				transform: rotate(0deg);
			}
			100%{
				transform: rotate(360deg);
			}
		}
  	</style>