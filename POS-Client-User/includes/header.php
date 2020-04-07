	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../assets/images/Logo.jpg">
	<title>TechMasters Support System</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
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

	<!-- Theme JS files -->
	<script type="text/javascript" src="../../assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/pickers/daterangepicker.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/ui/nicescroll.min.js"></script>

	<script type="text/javascript" src="../../assets/js/core/app.js"></script>
	<script type="text/javascript" src="../../assets/js/pages/dashboard.js"></script>
	<script type="text/javascript" src="../../assets/js/pages/layout_sidebar_sticky_custom.js"></script>

	<script type="text/javascript" src="../../assets/js/plugins/ui/ripple.min.js"></script>
	<!-- /theme JS files -->
	<script type="text/javascript" src="../../assets/js/plugins/visualization/c3/c3.min.js"></script>
  	<script type="text/javascript" src="../../assets/js/charts/c3/c3_advanced.js"></script>
  	<script type="text/javascript" src="../../assets/js/charts/c3/c3_axis.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/tables/datatables/extensions/responsive.min.js"></script>
  	<script type="text/javascript" src="../../assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
	<script type="text/javascript" src="../../assets/js/pages/datatables_extension_buttons_html5.js"></script>
	
	<script type="text/javascript" src="../../assets/js/pages/datatables_responsive.js"></script>
    <link rel="stylesheet" href="../../iziToast/dist/css/iziToast.min.css">
    <script src="../../iziToast/dist/js/iziToast.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../../assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="../../assets/js/plugins/notifications/bootbox.min.js"></script>
	<script type="text/javascript" src="../../assets/js/plugins/notifications/sweet_alert.min.js"></script>
	  <script type="text/javascript" src="../../assets/js/pages/form_select2.js"></script>
	  
	<style>
		#lock-modal {
			background-color: black;
			opacity: 0.6;
			position: absolute;
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
			top: 0;
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