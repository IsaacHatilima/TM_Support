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
				
				<li class="<?php if(isset($atm)){echo $atm; } ?>"><a href="ATMDetails"><i class="icon-display4 position-left"></i> ATMs</a></li>
				<li class="dropdown <?php if(isset($caller)){echo $caller; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
						<i class="icon-files-empty position-left"></i> Calls <span class="caret"></span>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li class="<?php if(isset($newatmcall)){echo $newatmcall; } ?>"><a href="NewCall"><i class="icon-file-plus position-left"></i> Create Call</a></li>
						<li class="<?php if(isset($atmcall)){echo $atmcall; } ?>"><a href="ATMCalls"><i class="icon-file-spreadsheet position-left"></i> All Calls</a></li>
					</ul>
				</li>
				<li class="dropdown <?php if(isset($reports)){echo $reports; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
						<i class="icon-chart position-left"></i> Reports <span class="caret"></span>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li class="<?php if(isset($year)){echo $year; } ?>"><a href="AnualReports"><i class="icon-calendar2 position-left"></i> Anual</a></li>
						<li class="<?php if(isset($range)){echo $range; } ?>"><a href="DateRange"><i class="icon-calendar52 position-left"></i> Date Range</a></li>
					</ul>
				</li>
				<li class="<?php if(isset($sla)){echo $sla; } ?>"><a href="SLATimes"><i class="icon-file-check position-left"></i> SLA Times</a></li>
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
