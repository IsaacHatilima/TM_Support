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
				<li class="dropdown <?php if(isset($users)){echo $users; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
						<i class="icon-users position-left"></i> Users <span class="caret"></span>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li class="<?php if(isset($addClient)){echo $addClient; } ?>"><a href="AddClientUser"><i class="icon-arrow-right5"></i> <span>Add Client User</span></a></li>
						<li class="<?php if(isset($viewClient)){echo $viewClient; } ?>"><a href="ViewClientUsers"><i class="icon-arrow-right5"></i> <span>View Clients Users</span></a></li>
						<li class="<?php if(isset($addEng)){echo $addEng; } ?>"><a href="AddEngineer"><i class="icon-arrow-right5"></i> <span>Add Engineer</span></a></li>
						<li class="<?php if(isset($viewEng)){echo $viewEng; } ?>"><a href="ViewEngineers"><i class="icon-arrow-right5"></i> <span>View Engineers</span></a></li>
					</ul>
				</li>
				<li class="dropdown <?php if(isset($cli)){echo $cli; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
						<i class="icon-office position-left"></i> Clients <span class="caret"></span>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li class="<?php if(isset($addBank)){echo $addBank; } ?>"><a href="AddClient"><i class="icon-arrow-right5"></i> <span>Add Client</span></a></li>
						<li class="<?php if(isset($viewBank)){echo $viewBank; } ?>"><a href="ViewClient"><i class="icon-arrow-right5"></i> <span>View Clients</span></a></li>
					</ul>
				</li>
				<li class="dropdown <?php if(isset($categos)){echo $categos; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
						<i class="icon-tree5 position-left"></i> Categories <span class="caret"></span>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li class="<?php if(isset($cate)){echo $cate; } ?>"><a href="Categories"><i class="icon-arrow-right5"></i> <span>Add Categories</span></a></li>
						<li class="<?php if(isset($subcate)){echo $subcate; } ?>"><a href="SubCategory"><i class="icon-arrow-right5"></i> <span>Add Sub-Categories</span></a></li>
					</ul>
				</li>
				<li class="<?php if(isset($atm)){echo $atm; } ?>"><a href="ATMDetails"><i class="icon-display4 position-left"></i> ATMs</a></li>
				<li class="<?php if(isset($atmcall)){echo $atmcall; } ?>"><a href="ATMCalls"><i class="icon-files-empty position-left"></i> Calls</a></li>
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
