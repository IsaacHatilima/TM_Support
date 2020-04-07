<?php include 'navpoint.php'; ?>
<div class="sidebar sidebar-main sidebar-default">
	<div class="sidebar-fixed">
		<div class="sidebar-content">
			<div class="sidebar-category sidebar-category-visible">
				<div class="category-title h6">
					<span>Main navigation</span>
				</div>
				<div class="category-content no-padding">
					<ul class="navigation navigation-main navigation-accordion">
						<li class="navigation-header"><span>User Control</span> <i class="icon-menu" title="Main pages"></i></li>
							<li><a href="AddClientUser"><i class="icon-gear"></i> <span>Account Settings</span></a></li>
							<li><a href="../core/Logout"><i class="icon-switch"></i> <span>Logout</span></a></li>

						<li class="navigation-header"><span>System Control</span> <i class="icon-menu" title="Main pages"></i></li>
						<!-- Calls -->
						<li class="<?php echo $allcalls; ?>"><a href="POSCalls"><i class="icon-stack-text"></i> <span>POS Calls</span></a></li>
						<!-- /Calls -->
						<!-- User MGT -->
						<li>
							<a href="#"><i class="icon-users4"></i> <span>Users</span></a>
							<ul>
								<li class="<?php echo $addClient; ?>"><a href="AddClientUser"><i class="icon-arrow-right5"></i> <span>Add Client User</span></a></li>
								<li class="<?php echo $viewClient; ?>"><a href="ViewClients"><i class="icon-arrow-right5"></i> <span>View Clients Users</span></a></li>
								<li class="<?php echo $addEng; ?>"><a href="AddEngineer"><i class="icon-arrow-right5"></i> <span>Add Engineer</span></a></li>
								<li class="<?php echo $viewEng; ?>"><a href="ViewEngineers"><i class="icon-arrow-right5"></i> <span>View Engineers</span></a></li>
							</ul>
						</li>
						<!-- /User MGT -->
						<!-- Banks -->
						<li>
							<a href="#"><i class="icon-office"></i> <span>Banks</span></a>
							<ul>
								<li class="<?php echo $addBank; ?>"><a href="AddBank"><i class="icon-arrow-right5"></i> <span>Add Bank</span></a></li>
								<li class="<?php echo $viewBank; ?>"><a href="ViewBanks"><i class="icon-arrow-right5"></i> <span>View Banks</span></a></li>	
							</ul>
						</li>
						<!-- /Banks -->
						<!-- Categories -->
						<li>
							<a href="#"><i class="icon-tree5"></i> <span>Categories</span></a>
							<ul>
								<li class="<?php echo $cate; ?>"><a href="Categories"><i class="icon-arrow-right5"></i> <span>Add Categories</span></a></li>
								<li class="<?php echo $subcate; ?>"><a href="SubCategory"><i class="icon-arrow-right5"></i> <span>Add Sub-Categories</span></a></li>	
							</ul>
						</li>
						<!-- /Categories -->
						<!-- Mechants -->
						<li class="<?php echo $mech; ?>"><a href="Mechants"><i class="icon-magazine"></i> <span>Mechants</span></a></li>
						<!-- /Mechants -->
						<!-- Mechants -->
						<li class="<?php echo $dev; ?>"><a href="Devices"><i class="icon-iphone"></i> <span>Devices</span></a></li>
						<!-- /Mechants -->
						<!-- Reports -->
						<li class="navigation-header"><span>Reports</span> <i class="icon-menu" title="Main pages"></i></li>
						<li>
							<a href="#"><i class="icon-file-download"></i> <span>Tabular Reports</span></a>
							<ul>
								<li class="<?php echo $yearlyR; ?>"><a href="index.html"><i class="icon-arrow-right5"></i> <span>Yearly</span></a></li>
								<li class="<?php echo $monthlyR; ?>"><a href="index.html"><i class="icon-arrow-right5"></i> <span>Monthly</span></a></li>
								<li class="<?php echo $dailyR; ?>"><a href="index.html"><i class="icon-arrow-right5"></i> <span>Daily</span></a></li>	
								<li class="<?php echo $dateRange; ?>"><a href="index.html"><i class="icon-arrow-right5"></i> <span>Date Range</span></a></li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="icon-stats-decline"></i> <span>Chart Reports</span></a>
							<ul>
								<li class="<?php echo $yearlyC; ?>"><a href="index.html"><i class="icon-arrow-right5"></i> <span>Yearly</span></a></li>
								<li class="<?php echo $monthlyC; ?>"><a href="index.html"><i class="icon-arrow-right5"></i> <span>Monthly</span></a></li>
								<li class="<?php echo $dailyC; ?>"><a href="index.html"><i class="icon-arrow-right5"></i> <span>Daily</span></a></li>	
								<li class="<?php echo $dateRangeC; ?>"><a href="index.html"><i class="icon-arrow-right5"></i> <span>Date Range</span></a></li>
							</ul>
						</li>
						<!-- /Reports -->									
						<!-- Config -->
						<li class="navigation-header"><span>System Config</span> <i class="icon-menu" title="Main pages"></i></li>
						<li><a href="index.html"><i class="icon-alarm"></i> <span>SLA Times</span></a></li>
						<!-- /Config -->

					</ul>
				</div>
			</div>
		</div>
	</div>
</div>