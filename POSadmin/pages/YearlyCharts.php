
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include '../includes/header.php'; ?>
</head>

<body class="navbar-bottom navbar-top">
	<?php include '../includes/topnav.php'; ?>


	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">              
				<!-- Overall -->
				<?php include '../core/IndexChart2.php'; ?>
                <div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title text-semibold"><?php echo date('Y') ?> Retail against Forecourt</h6>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                	</ul>
	                	</div>
					</div>

					<div class="panel-body">
						<div class="chart-container">
							<div class="chart" id="yearsChart"></div>
						</div>
					</div>
				</div>
                <!-- PIE -->
				<?php include '../core/PieCharts.php'; ?>
                <div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title text-semibold"><?php echo date('Y') ?> Total Call Statistics</h6>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                	</ul>
	                	</div>
					</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="chart-container text-center">
                                    <div class="display-inline-block" id="c3-pie-chart"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="chart-container text-center">
                                    <div class="display-inline-block" id="c3-pie-chart2"></div>
                                </div>
                            </div>
							<div class="col-md-4">
                                <div class="chart-container text-center">
                                    <div class="display-inline-block" id="c3-pie-chart3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
                <!-- Bars Qualter stats Quarterly -->
                <div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title text-semibold">Quarterly Statistics</h6>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                	</ul>
	                	</div>
					</div>
					<?php include '../core/QuarterlyChart.php'; ?>
					<div class="panel-body">
						<div class="chart-container">
							<div class="chart" id="c3-data-color"></div>
						</div>
					</div>
				</div>
                <!-- Bars Province stats -->
                <div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title text-semibold">Annual Provincial Statistics</h6>
						<div class="heading-elements">
							<ul class="icons-list">
		                		<li><a data-action="collapse"></a></li>
		                	</ul>
	                	</div>
					</div>

					<div class="panel-body">
						<div class="chart-container">
							<div class="chart" id="province"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
        // Yearly Chart
		var axis_tick_rotation = c3.generate({
			bindto: '#yearsChart',
			size: { height: 400 },
			data: {
				x : 'x',
				columns: [
					['x', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

					['Retail', <?php echo $Rjan['Rjan']; ?>, <?php echo $Rfeb['Rfeb']; ?>, <?php echo $Rmar['Rmar']; ?>, <?php echo $Rapr['Rapr']; ?>,  <?php echo $Rmay['Rmay']; ?>, <?php echo $Rjun['Rjun']; ?>,<?php echo $Rjul['Rjul']; ?>,<?php echo $Raug['Raug']; ?>,<?php echo $Rsep['Rsep']; ?>,<?php echo $Roct['Roct']; ?>,<?php echo $Rnov['Rnov']; ?>,<?php echo $Rdec['Rdec']; ?>],

					['Forecourt', <?php echo $Fjan['Fjan']; ?>, <?php echo $Ffeb['Ffeb']; ?>, <?php echo $Fmar['Fmar']; ?>, <?php echo $Fapr['Fapr']; ?>,  <?php echo $Fmay['Fmay']; ?>, <?php echo $Fjun['Fjun']; ?>,<?php echo $Fjul['Fjul']; ?>,<?php echo $Faug['Faug']; ?>,<?php echo $Fsep['Fsep']; ?>,<?php echo $Foct['Foct']; ?>,<?php echo $Fnov['Fnov']; ?>,<?php echo $Fdec['Fdec']; ?>]
				],
				type: 'bar',
				colors: {
					Retail: 'aqua',
					Forecourt: 'teal'
				}
			},
			
			axis: {
				x: {
					type: 'category',
					// tick: {
					// 	rotate: 180
					// },
					height: 80
				}
			},
			grid: {
				x: {
					show: true
				}
			}
        });
        // Pie 1 
        var pie_chart = c3.generate({
            bindto: '#c3-pie-chart',
            size: { width: 360 },
            color: {
                pattern: ['#00BCD4','#FF9800', '#4CAF50']
            },
            data: {
                columns: [
                    ["New", <?php echo $new_calls; ?>],
                    ["Pending", <?php echo $pen_calls; ?>],
                    ["Closed", <?php echo $clo_calls; ?>],
                ],
                type : 'pie'
            }
        });
        // Pie 2 
        var pie_chart = c3.generate({
            bindto: '#c3-pie-chart2',
            size: { width: 360 },
            color: {
                pattern: ['#00BCD4','#FF9800', '#4CAF50', '#FF4233', '#33FFD7', '#9F33FF']
            },
            data: {
                columns: [
                    ["Hardware", <?php echo $hardware; ?>],
                    ["Software", <?php echo $software; ?>],
                    ["Infrastructure", <?php echo $infrastructure; ?>],
                    ["Installation", <?php echo $installs; ?>],
                    ["Stationary", <?php echo $stations; ?>],
                    ["Connectivity", <?php echo $connects; ?>],
                ],
                type : 'pie'
            }
        });
		// Pie 3 
		var pie_chart = c3.generate({
            bindto: '#c3-pie-chart3',
            size: { width: 360 },
            color: {
                pattern: ['#00BCD4', '#9F33FF']
            },
            data: {
                columns: [
                    ["Devices", <?php echo $devices; ?>],
                    ["Stationary", <?php echo $deliveries; ?>]
                ],
                type : 'pie'
            }
        });

        // Qualter Bars
        var data_color = c3.generate({
            bindto: '#c3-data-color',
			size: { height: 400 },
			data: {
				x : 'x',
				columns: [
					['x', 'Q1', 'Q2', 'Q3', 'Q4'],

					['Retail', <?php echo $qota1; ?>,<?php echo $qota2; ?>,<?php echo $qota3; ?>,<?php echo $qota4; ?>],

					['Forecourt', <?php echo $fqota1; ?>,<?php echo $fqota2; ?>,<?php echo $fqota3; ?>,<?php echo $fqota4; ?>]
				],
				type: 'bar',
				colors: {
					Retail: '#FF4233',
                    Forecourt: '#FFBB33'
				}
			},
			
			axis: {
				x: {
					type: 'category',
					// tick: {
					// 	rotate: 180
					// },
					height: 80
				}
			},
			grid: {
				x: {
					show: true
				}
			}
        });

        // Province Bars
        // var data_color = c3.generate({
        //     bindto: '#province',
		// 	size: { height: 400 },
		// 	data: {
		// 		x : 'x',
		// 		columns: [
		// 			['x', 'Central', 'Copperbelt', 'Eastern', 'Luapula', 'Lusaka', 'Muchinga', 'Nothern', 'North-Western','Southern','Western'],

		// 			['Retail', 89,85,150,210, 89,85,150,210,98,189],

		// 			['Forecourt', 100,160,98,189, 89,85,150,210,98,189]
		// 		],
		// 		type: 'bar',
		// 		colors: {
		// 			Retail: '#900C3F',
        //             Forecourt: '#FF5733 '
		// 		}
		// 	},
			
		// 	axis: {
		// 		x: {
		// 			type: 'category',
		// 			height: 80
		// 		}
		// 	},
		// 	grid: {
		// 		x: {
		// 			show: true
		// 		}
		// 	}
        // });

    </script>
</body>
</html>
