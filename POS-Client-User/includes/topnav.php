	<?php include_once('navpoint.php') ?>

	<div class="navbar navbar-inverse bg-indigo navbar-fixed-top">
		<div class="navbar-header">

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">

				<li class="<?php if(isset($index)){echo $index; } ?>"><a href="./"><i class="icon-home position-left"></i> Home</a></li>
				<!-- <li class="dropdown <?php if(isset($users)){echo $users; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
						<i class="icon-users position-left"></i> Users <span class="caret"></span>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li class="<?php if(isset($addClient)){echo $addClient; } ?>"><a href="AddClientUser"><i class="icon-arrow-right5"></i> <span>Add Client User</span></a></li>
						<li class="<?php if(isset($viewClient)){echo $viewClient; } ?>"><a href="ViewClientUsers"><i class="icon-arrow-right5"></i> <span>View Clients Users</span></a></li>
						<li class="<?php if(isset($addEng)){echo $addEng; } ?>"><a href="AddEngineer"><i class="icon-arrow-right5"></i> <span>Add Engineer</span></a></li>
						<li class="<?php if(isset($viewEng)){echo $viewEng; } ?>"><a href="ViewEngineers"><i class="icon-arrow-right5"></i> <span>View Engineers</span></a></li>
					</ul>
				</li> -->
				<!-- <li class="dropdown <?php if(isset($cli)){echo $cli; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
						<i class="icon-office position-left"></i> Clients <span class="caret"></span>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li class="<?php if(isset($addBank)){echo $addBank; } ?>"><a href="AddClient"><i class="icon-arrow-right5"></i> <span>Add Client</span></a></li>
						<li class="<?php if(isset($viewBank)){echo $viewBank; } ?>"><a href="ViewClient"><i class="icon-arrow-right5"></i> <span>View Clients</span></a></li>
					</ul>
				</li> -->
				<!-- <li class="dropdown <?php if(isset($categos)){echo $categos; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
						<i class="icon-tree5 position-left"></i> Categories <span class="caret"></span>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li class="<?php if(isset($cate)){echo $cate; } ?>"><a href="Categories"><i class="icon-arrow-right5"></i> <span>Add Categories</span></a></li>
						<li class="<?php if(isset($subcate)){echo $subcate; } ?>"><a href="SubCategory"><i class="icon-arrow-right5"></i> <span>Add Sub-Categories</span></a></li>
					</ul>
				</li> -->
				<li class="dropdown <?php if(isset($mechdev)){echo $mechdev; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
						<i class="icon-iphone position-left"></i> Mechants & Devices <span class="caret"></span>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li class="<?php if(isset($mech)){echo $mech; } ?>"><a href="Mechants"><i class="icon-magazine"></i> <span>Mechants</span></a></li>
						<li class="<?php if(isset($dev)){echo $dev; } ?>"><a href="Devices"><i class="icon-iphone"></i> <span>Devices</span></a></li>
						<!-- <li class="<?php if(isset($repdev)){echo $repdev; } ?>"><a href="RepairedDevices"><i class="icon-iphone"></i> <span>Devices Repaired</span></a></li> -->
					</ul>
				</li>
				<li class="dropdown <?php if(isset($ticks)){echo $ticks; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
						<i class="icon-file-plus position-left"></i> Ticket Entry <span class="caret"></span>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li class="<?php if(isset($newtick)){echo $newtick; } ?>"><a href="CreateTicket"><i class="icon-arrow-right5"></i> <span>Create Ticket</span></a></li>
						<!-- <li class="<?php if(isset($edittick)){echo $edittick; } ?>"><a href="EditTicket"><i class="icon-arrow-right5"></i> <span>Edit Ticket</span></a></li>
						<li class="<?php if(isset($deltick)){echo $deltick; } ?>"><a href="DeleteTicket"><i class="icon-arrow-right5"></i> <span>Delete Ticket</span></a></li> -->
						<li class="<?php if(isset($ocals)){echo $ocals; } ?>"><a href="POSCalls"><i class="icon-arrow-right5"></i> <span>All Ticket</span></a></li>
					</ul>
				</li>
				<li class="dropdown <?php if(isset($reports)){echo $reports; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
						<i class="icon-chart position-left"></i> Reports <span class="caret"></span>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<span class="menu-heading underlined">Tablura Reports</span>
						<li class="<?php if(isset($year)){echo $year; } ?>"><a href="YearlyTabularCalls"><i class="icon-arrow-right5"></i> <span>Yearly</span></a></li>
						<li class="<?php if(isset($month)){echo $month; } ?>"><a href="MonthlyTabularCalls"><i class="icon-arrow-right5"></i> <span>Monthly</span></a></li>
						<li class="<?php if(isset($week)){echo $week; } ?>"><a href="WeeklyTabularCalls"><i class="icon-arrow-right5"></i> <span>Weekly</span></a></li>	
						<li class="<?php if(isset($days)){echo $days; } ?>"><a href="DailyTabularCalls"><i class="icon-arrow-right5"></i> <span>Daily (EOD)</span></a></li>	
						<li class="<?php if(isset($range)){echo $range; } ?>"><a href="DateRangeTabularCalls"><i class="icon-arrow-right5"></i> <span>Date Range</span></a></li>

						<span class="menu-heading underlined">Graphical Reports</span>
						<li class="<?php if(isset($yearchart)){echo $yearchart; } ?>"><a href="YearlyCharts"><i class="icon-arrow-right5"></i> <span>Yearly</span></a></li>
						<li class="<?php if(isset($year)){echo $year; } ?>"><a href="MonthlyCharts"><i class="icon-arrow-right5"></i> <span>Monthly</span></a></li>
						<li class="<?php if(isset($year)){echo $year; } ?>"><a href="WeeklyCharts"><i class="icon-arrow-right5"></i> <span>Weekly</span></a></li>	
						<li class="<?php if(isset($year)){echo $year; } ?>"><a href="DailyCharts"><i class="icon-arrow-right5"></i> <span>Daily</span></a></li>	
					</ul>
				</li>
			</ul>

			<ul class="nav navbar-nav navbar-right">

				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
						<img src="../../assets/images/placeholder.jpg" alt="">
						<span><?php echo $firstName; ?></span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="ChangePassword"><i class="icon-cog5"></i> Change Password</a></li>
						<li><a href="../core/Logout"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>