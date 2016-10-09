<script>
	loadCSS("<?php echo $assets ?>/real/css/climacons-font.css");
	loadCSS("<?php echo $assets ?>/real/plugins/jquery-ui/css/jquery-ui-1.10.4.min.css");
	loadCSS("<?php echo $assets ?>/real/plugins/morris/css/morris.css");
	loadCSS("<?php echo $assets ?>/real/plugins/jvectormap/css/jquery-jvectormap-1.2.2.css");
	loadCSS("<?php echo $assets ?>/real/plugins/daterangepicker/css/daterangepicker-bs3.css");
	
	var requireJS = [
		"<?php echo $assets ?>/real/plugins/jquery-ui/js/jquery-ui-1.10.4.min.js", 
		"<?php echo $assets ?>/real/plugins/moment/moment.min.js", 
		"<?php echo $assets ?>/real/plugins/flot/jquery.flot.min.js", 
		"<?php echo $assets ?>/real/plugins/flot/jquery.flot.resize.min.js", 
		"<?php echo $assets ?>/real/plugins/flot/jquery.flot.time.min.js", 
		"<?php echo $assets ?>/real/plugins/flot/jquery.flot.spline.min.js",
		"<?php echo $assets ?>/real/plugins/autosize/jquery.autosize.min.js", 
		"<?php echo $assets ?>/real/plugins/placeholder/jquery.placeholder.min.js", 
		"<?php echo $assets ?>/real/plugins/datatables/js/jquery.dataTables.min.js", 
		"<?php echo $assets ?>/real/plugins/datatables/js/dataTables.bootstrap.min.js", 
		"<?php echo $assets ?>/real/plugins/raphael/raphael.min.js", 
		"<?php echo $assets ?>/real/plugins/morris/js/morris.min.js", 
		"<?php echo $assets ?>/real/plugins/jvectormap/js/jquery-jvectormap-1.2.2.min.js", 
		"<?php echo $assets ?>/real/plugins/jvectormap/js/jquery-jvectormap-world-mill-en.js", 
		"<?php echo $assets ?>/real/plugins/jvectormap/js/gdp-data.js",
		"<?php echo $assets ?>/real/plugins/gauge/gauge.min.js",
		"<?php echo $assets ?>/real/plugins/daterangepicker/js/daterangepicker.min.js",
	]; 
	
	loadJS(requireJS, "<?php echo $assets ?>/real/js/pages/index.js");
	
</script>
			
			<ul class="statistics">
				<li>
					<i class="icon-users"></i>
					<div class="number">87.500</div>
					<div class="title">Visitors</div>
					<div class="progress thin">
					  	<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100" style="width: 73%">
					    	<span class="sr-only">73% Complete (success)</span>
					  	</div>
					</div>
				</li>
				<li>
					<i class="icon-user-follow"></i>
					<div class="number">385</div>
					<div class="title">New clients</div>
					<div class="progress thin">
					  	<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100" style="width: 73%">
					    	<span class="sr-only">73% Complete (success)</span>
					  	</div>
					</div>
				</li>
				<li>
					<i class="icon-basket-loaded"></i>
					<div class="number">1238</div>
					<div class="title">Products sold</div>
					<div class="progress thin">
					  	<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100" style="width: 73%">
					    	<span class="sr-only">73% Complete (success)</span>
					  	</div>
					</div>
				</li>
				<li>
					<i class="icon-pie-chart"></i>
					<div class="number">28%</div>
					<div class="title">Returning Visitors</div>
					<div class="progress thin">
					  	<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100" style="width: 73%">
					    	<span class="sr-only">73% Complete (success)</span>
					  	</div>
					</div>
				</li>
				<li>
					<i class="icon-speedometer"></i>
					<div class="number">5:34:11</div>
					<div class="title">Avg. time</div>
					<div class="progress thin">
					  	<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100" style="width: 73%">
					    	<span class="sr-only">73% Complete (success)</span>
					  	</div>
					</div>
				</li>
				<li>
					<i class="icon-speech"></i>
					<div class="number">972</div>
					<div class="title">New comments</div>
					<div class="progress thin">
					  	<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100" style="width: 73%">
					    	<span class="sr-only">73% Complete (success)</span>
					  	</div>
					</div>
				</li>
			</ul>			
			
			<div class="row">
				
				<div class="col-lg-9">
					
					<div class="panel panel-default">
						
						<div class="panel-heading">
							<i class="icon-bar-chart"></i><h2>Traffic &amp; Revenue</h2>							
							<div id="daterange" class="selectbox pull-right hidden-xs">
								<i class="icon-calendar"></i>
								<span>July 4, 2014 - August 2, 2014</span> <b class="caret"></b>
							</div>
						</div>
						
						<div class="panel-body">
							
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
							  	<li class="active"><a href="#months" role="tab" data-toggle="tab">Monthly</a></li>
							  	<li class="hidden-xs"><a href="#" role="tab" data-toggle="tab">Weekly</a></li>
							  	<li class="hidden-xs"><a href="#" role="tab" data-toggle="tab">Daily</a></li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
							  	<div class="tab-pane active" id="months">
							  		<div id="main-chart" style="height:390px"></div>
							  	</div>
							  	<div class="tab-pane" id="weeks">...</div>
							  	<div class="tab-pane" id="days">...</div>
							</div>		

						</div>
						
						<div class="panel-footer">
							<ul class="panel-footer-stats">
								<li>
									<canvas id="gauge-success" height=50 width=70></canvas>
									<span class="number">148.125</span>
									<span class="title">New users</span>
								</li>
								<li>
									<canvas id="gauge-info" height=50 width=70></canvas>
									<span class="number">452.352</span>
									<span class="title">Pageviews</span>
								</li>
								<li>
									<canvas id="gauge-warning" height=50 width=70></canvas>
									<span class="number">2,19</span>
									<span class="title">Pages / Visit</span>
								</li>
								<li>
									<canvas id="gauge-danger" height=50 width=70></canvas>
									<span class="number">59,83%</span>
									<span class="title">Bounce Rate</span>
								</li>
								<li>
									<canvas id="gauge-primary" height=50 width=70></canvas>
									<span class="number">70,79%</span>
									<span class="title">New Visits</span>
								</li>								
							</ul>		
						</div>
						
					</div>	
					
				</div><!--/col-->
				
				<div class="col-lg-3 col-sm-6">
					
					<div class="panel panel-default">
						
						<div class="panel-body text-center" style="height:233px">
							<h2>Revenue</h2>
							<div style="width:300px;left:50%;position:absolute;margin-left:-150px;">
								<canvas id="gauge1"></canvas>
							</div>
						</div>	
						<div class="panel-footer">
							<strong>$11.234,00</strong>
							<span class="pull-right"><i class="fa fa-arrow-circle-o-up text-success"></i> 15%</span>
						</div>	
						
					</div>	
										
				</div><!--/col-->
				
				<div class="col-lg-3 col-sm-6">
					
					<div class="panel panel-default">
						
						<div class="panel-body text-center" style="height:232px">
							<h2>Profit</h2>
							<div style="width:300px;left:50%;position:absolute;margin-left:-150px;">
								<canvas id="gauge2"></canvas>
							</div>	
						</div>	
						<div class="panel-footer">
							<strong>$3.733,00</strong>
							<span class="pull-right"><i class="fa fa-arrow-circle-o-down text-danger"></i> 53%</span>
						</div>	
						
					</div>	
										
				</div><!--/.col-->			
				
			</div><!--/row-->
			
			<div class="row">
				
				<div class="col-md-3 col-sm-6">
					
					<div class="social-box facebook">
						<i class="fa fa-facebook"></i>
						<ul>
							<li>
								<strong>89k</strong>
								<span>friends</span>
							</li>
							<li>
								<strong>459</strong>
								<span>feeds</span>
							</li>
						</ul>
					</div><!--/social-box-->			
					
				</div><!--/col-->
				
				<div class="col-md-3 col-sm-6">
					
					<div class="social-box twitter">
						<i class="fa fa-twitter"></i>
						<ul>
							<li>
								<strong>973k</strong>
								<span>followers</span>
							</li>
							<li>
								<strong>1.792</strong>
								<span>tweets</span>
							</li>
						</ul>
					</div><!--/social-box-->			
					
				</div><!--/col-->
				
				<div class="col-md-3 col-sm-6">
					
					<div class="social-box linkedin">
						<i class="fa fa-linkedin"></i>
						<ul>
							<li>
								<strong>500+</strong>
								<span>contacts</span>
							</li>
							<li>
								<strong>292</strong>
								<span>feeds</span>
							</li>
						</ul>
					</div><!--/social-box-->			
					
				</div><!--/col-->
				
				<div class="col-md-3 col-sm-6">
					
					<div class="social-box google-plus">
						<i class="fa fa-google-plus"></i>
						<ul>
							<li>
								<strong>894</strong>
								<span>followers</span>
							</li>
							<li>
								<strong>92</strong>
								<span>circles</span>
							</li>
						</ul>
					</div><!--/social-box-->			
					
				</div><!--/col-->	
				
			</div><!--/row-->
			
			<div class="row">
				
				<div class="col-lg-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2><i class="icon-globe-alt"></i>Top Countries</h2>
							<div class="panel-actions">
								<a href="#" class="btn-setting"><i class="icon-settings"></i></a>
								<a href="#" class="btn-minimize"><i class="icon-arrow-up"></i></a>
								<a href="#" class="btn-close"><i class="icon-close"></i></a>
							</div>
						</div>
						<div class="panel-body">
							<div id="map" style="height:374px;"></div>		
						</div>
					</div>	
				</div><!--/col-->
				
				<div class="col-lg-3 col-sm-6">
					
					<div class="panel panel-default">
						
						<div class="panel-heading">
							<i class="icon-compass"></i><h2>Traffic</h2>
							
							<div class="panel-actions">
								<a href="#" class="btn-setting"><i class="icon-settings"></i></a>
								<a href="#" class="btn-minimize"><i class="icon-arrow-up"></i></a>
								<a href="#" class="btn-close"><i class="icon-close"></i></a>
							</div>

						</div>
						
						<div class="panel-body">

							<h6>Visits (40% - 29.703 Users)</h6>
							<div class="progress thin">
							  	<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
							    	<span class="sr-only">40% Complete (success)</span>
							  	</div>
							</div>

							<h6>Unique (20% - 24.093 Unique Users)</h6>
							<div class="progress thin">
							  	<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
							    	<span class="sr-only">20% Complete</span>
							  	</div>
							</div>

							<h6>Pageviews (60% - 78.706 Views)</h6>
							<div class="progress thin">
							  	<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
							    	<span class="sr-only">60% Complete (warning)</span>
							  	</div>
							</div>

							<h6>New Users (80% - 22.123 Users)</h6>
							<div class="progress thin">
							  	<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
							    	<span class="sr-only">80% Complete</span>
							  	</div>
							</div>

							<h6>Bounce Rate (40.15%)</h6>
							<div class="progress thin">
							  	<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
							    	<span class="sr-only">40% Complete (success)</span>
							  	</div>
							</div>
							
							<h6>Visits (40% - 29.703 Users)</h6>
							<div class="progress thin">
							  	<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
							    	<span class="sr-only">40% Complete (success)</span>
							  	</div>
							</div>

							<h6>Unique (20% - 24.093 Unique Users)</h6>
							<div class="progress thin">
							  	<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
							    	<span class="sr-only">20% Complete</span>
							  	</div>
							</div>

						</div>
					</div>		
				</div><!--/col-->
				
				<div class="col-lg-3 col-sm-6">
					
					<div class="panel panel-default">

						<div class="panel-body weather widget">
							
							<div class="today text-center">
								
								<i class="climacon sun"></i>
								
								<div><strong>31/22°C London</strong></div>

							</div>
							
							<ul class="forecast">
								<li>
									<strong>MON</strong>
									<i class="climacon lightning sun"></i>
									<div class="small">28/17°C</div>
								</li>
								<li>
									<strong>TUE</strong>
									<i class="climacon fog sun"></i>
									<div class="small">24/11°C</div>
								</li>
								<li>
									<strong>WED</strong>
									<i class="climacon hail sun"></i>
									<div class="small">25/14°C</div>
								</li>	
							</ul>
															
						</div>
					</div>
					
				</div><!--/col-->		
			
			</div><!--/row-->		
			
			<div class="row">	
						
				<div class="col-lg-7 col-md-12">
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2><i class="icon-check"></i>Tasks in Progress</h2>
							<div class="panel-actions">
								<a href="#" class="btn-setting"><i class="icon-settings"></i></a>
								<a href="#" class="btn-minimize"><i class="icon-arrow-up"></i></a>
								<a href="#" class="btn-close"><i class="icon-close"></i></a>
							</div>
							<ul class="nav nav-tabs" id="recent">
							  	<li class="active"><a href="#tasks">Tasks</a></li>
							  	<li><a href="#tickets">Tickets</a></li>
							</ul>
						</div>
						<div class="panel-body">
							<div class="tab-content">
								<div class="tab-pane active" id="tasks">
									<table class="table bootstrap-datatable datatable small-font">
										<thead>
											  <tr>
												  <th>Task</th>
												  <th>Assigned to</th>
												  <th>Progress</th>
												  <th class="center">Status</th>
											  </tr>
										  </thead>   
										  <tbody>
											<tr>
												<td>SEO Optimisation</td>
												<td>Charly Brown</td>
												<td>
													<div class="progress thin">
													  	<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100" style="width: 73%">
													    	<span class="sr-only">73% Complete (success)</span>
													  	</div>
													</div>
												</td>
												<td class="text-center text-info">
													Active
												</td>
											</tr>
											<tr>
												<td>App Development</td>
												<td>John Smith</td>
												<td>
													<div class="progress thin">
													  	<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%">
													    	<span class="sr-only">95% Complete (success)</span>
													  	</div>
													</div>
												</td>
												<td class="text-center text-success">
													Active
												</td>
											</tr>
											<tr>
												<td>Hire Developers</td>
												<td>Megan Holms</td>
												<td>
													<div class="progress thin">
													  	<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="27" aria-valuemin="0" aria-valuemax="100" style="width: 27%">
													    	<span class="sr-only">27% Complete (success)</span>
													  	</div>
													</div>
												</td>
												<td class="text-center text-warning">
													Pending
												</td>
											</tr>
											<tr>
												<td>Growth Hacking</td>
												<td>Alan Wane</td>
												<td>
													<div class="progress thin">
													  	<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100" style="width: 11%">
													    	<span class="sr-only">11% Complete (success)</span>
													  	</div>
													</div>
												</td>
												<td class="text-center text-primary">
													Active
												</td>
											</tr>
											<tr>
												<td>A/B Tests</td>
												<td>Irina Cole</td>
												<td>
													<div class="progress thin">
													  	<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100" style="width: 73%">
													    	<span class="sr-only">73% Complete (success)</span>
													  	</div>
													</div>
												</td>
												<td class="text-center text-danger">
													Canceled
												</td>
											</tr>
											<tr>
												<td>Hacking</td>
												<td>Alan Wane</td>
												<td>
													<div class="progress thin">
													  	<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100" style="width: 11%">
													    	<span class="sr-only">11% Complete (success)</span>
													  	</div>
													</div>
												</td>
												<td class="text-center text-primary">
													Active
												</td>
											</tr>
											<tr>
												<td>New website development</td>
												<td>Megan Holms</td>
												<td>
													<div class="progress thin">
													  	<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="27" aria-valuemin="0" aria-valuemax="100" style="width: 27%">
													    	<span class="sr-only">27% Complete (success)</span>
													  	</div>
													</div>
												</td>
												<td class="text-center text-warning">
													Pending
												</td>
											</tr>
											<tr>
												<td>Hacking</td>
												<td>Alan Wane</td>
												<td>
													<div class="progress thin">
													  	<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100" style="width: 11%">
													    	<span class="sr-only">11% Complete (success)</span>
													  	</div>
													</div>
												</td>
												<td class="text-center text-primary">
													Active
												</td>
											</tr>											
										</tbody>
									</table>
								</div>	
							  	<div class="tab-pane" id="tickets">
									<table class="table bootstrap-datatable datatable small-font">
										<thead>
											<tr>
												<th>Status</th>
												<th>Date</th>
												<th>Description</th>
												<th>User</th>
												<th>Number</th>
											</tr>
										</thead>   
										<tbody>
											<tr>
												<td><span class="label label-success">Complete</span></td>
												<td>Jul 25, 2012 11:09</td>
												<td>Server problem</td>
												<td>Ashley Tan</td>
												<td><b>[#199278]</b></td>
											</tr>
											<tr>
												<td><span class="label label-info">In progress</span></td>
												<td>Jul 25, 2012 11:09</td>
												<td>Paypal Issue</td>
												<td>Chris Dan</td>
												<td><b>[#199276]</b></td>
											</tr>
											<tr>
												<td><span class="label label-danger">Rejected</span></td>
												<td>Jul 25, 2012 11:09</td>
												<td>IE7 Problem</td>
												<td>John Grand</td>
												<td><b>[#199275]</b></td>
											</tr>
											<tr>
												<td><span class="label label-warning">Suspended</span></td>
												<td>Jul 25, 2012 11:09</td>
												<td>Mobile App Problem</td>
												<td>Patricia Doyle</td>
												<td><b>[#199273]</b></td>
											</tr>
											<tr>
												<td><span class="label label-info">In progress</span></td>
												<td>Jul 25, 2012 11:09</td>
												<td>Mobile App Problem</td>
												<td>Melanie Brown</td>
												<td><b>[#199272]</b></td>
											</tr>
																					
										</tbody>
									</table>
							  	</div>
							</div>	 	
						</div>
					</div>
					
				</div><!--/col-->
				
				<div class="col-lg-5 col-md-12">
						
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2><i class="icon-list"></i>To Do List</h2>
							<div class="panel-actions">
								<a href="#" class="btn-setting"><i class="icon-settings"></i></a>
								<a href="#" class="btn-minimize"><i class="icon-arrow-up"></i></a>
								<a href="#" class="btn-close"><i class="icon-close"></i></a>
							</div>
						</div>
						<div class="panel-body no-padding">
							<div class="todo-list">
								<ul id="todo-1" class="todo-list-tasks">
									<li>
										<label class="custom-checkbox-item pull-left">
											<input class="custom-checkbox" type="checkbox"/>
											<span class="custom-checkbox-mark"></span>
										</label>
										<span class="desc">Solve server problem</span> 
									</li>
									<li>
										<label class="custom-checkbox-item pull-left">
											<input class="custom-checkbox" type="checkbox"/>
											<span class="custom-checkbox-mark"></span>
										</label>
										<span class="desc">New website development</span> 
									</li>
									<li>
										<label class="custom-checkbox-item pull-left">
											<input class="custom-checkbox" type="checkbox"/>
											<span class="custom-checkbox-mark"></span>
										</label>
										<span class="desc">Improve SEO Opitimisation</span> 
									</li>
									<li>
										<label class="custom-checkbox-item pull-left">
											<input class="custom-checkbox" type="checkbox"/>
											<span class="custom-checkbox-mark"></span>
										</label>
										<span class="desc">Find JavaScript Developers</span> 
									</li>
									<li>
										<label class="custom-checkbox-item pull-left">
											<input class="custom-checkbox" type="checkbox"/>
											<span class="custom-checkbox-mark"></span>
										</label>
										<span class="desc">Growth Hacking</span> 
									</li>
									<li>
										<label class="custom-checkbox-item pull-left">
											<input class="custom-checkbox" type="checkbox"/>
											<span class="custom-checkbox-mark"></span>
										</label>
										<span class="desc">Pay taxes</span> 
									</li>
								</ul>
								<ul class="completed"></ul>		
							</div>
							<div class="panel-footer">
								<div class="form-group">
									<input type="text" class="form-control" id="task-description" placeholder="Add new task">
								</div>
								<div class="btn-group">
									<button type="button" class="btn btn-link"><i class="icon-pointer"></i></button>
									<button type="button" class="btn btn-link"><i class="icon-users"></i></button>
									<button type="button" class="btn btn-link"><i class="icon-calendar"></i></button>
								</div>

								<div class="pull-right">
									<button id="add-task" type="button" class="btn btn-success">submit</button>
								</div>	
							</div>		
						</div>
					</div>

				</div><!--/col-->
					
			</div><!--/row-->	

			<div class="row">

				<div class="col-lg-12 activity">

					<ul>

						<li>
							<div class="author">
								<img src="assets/img/avatar.jpg" alt="avatar">
							</div>	
							<div class="header">
								<span class="label label-success">TASK</span> <strong>Mike</strong> added this task: <a href="#">Fixes for IE8 :)</a>
								<span class="location"> <i class="icon-clock"></i> Today, 10:00AM</span>
								<span class="time"> <i class="icon-pointer"></i> London</span>
							</div>	
						</li>
						
						<li>
							<div class="author">
								<img src="assets/img/avatar.jpg" alt="avatar">
							</div>	
							<div class="header">
								<span class="label label-info">COMMENT</span> <strong>Mike</strong> posted comment on: <a href="#">New mobile application for iOS Devices</a>
								<span class="location"> <i class="icon-clock"></i> Today, 10:00AM</span>
								<span class="time"> <i class="icon-pointer"></i> London</span>
							</div>
							<div class="description">
								<blockquote>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</blockquote>
							</div>		
						</li>
						
						<li>
							<div class="author">
								<img src="assets/img/avatar.jpg" alt="avatar">
							</div>	
							<div class="header">
								<span class="label label-warning">IMAGE</span> <strong>Mike</strong> Uploaded following pictures
								<span class="location"> <i class="icon-clock"></i> Today, 10:00AM</span>
								<span class="time"> <i class="icon-pointer"></i> London</span>
							</div>
							<div class="description">
								<div class="row">
									<div class="col-sm-3 col-xs-6" style="margin-bottom: 30px">
										<img src="assets/img/gallery/photo2.jpg" class="img-responsive img-thumbnail">
									</div>
									<div class="col-sm-3 col-xs-6" style="margin-bottom: 30px">
										<img src="assets/img/gallery/photo3.jpg" class="img-responsive img-thumbnail">
									</div>
									<div class="col-sm-3 col-xs-6" style="margin-bottom: 30px">
										<img src="assets/img/gallery/photo4.jpg" class="img-responsive img-thumbnail">
									</div>
									<div class="col-sm-3 col-xs-6" style="margin-bottom: 30px">
										<img src="assets/img/gallery/photo5.jpg" class="img-responsive img-thumbnail">
									</div>	
								</div>
							</div>		
						</li>
						
						<li>
							<div class="author">
								<img src="assets/img/avatar.jpg" alt="avatar">
							</div>	
							<div class="header">
								<span class="label label-info">CHECK IN</span> <strong>Mike</strong> Was in this place
								<span class="location"> <i class="icon-clock"></i> Today, 10:00AM</span>
								<span class="time"> <i class="icon-pointer"></i> London</span>
							</div>
							<div class="description">
								<div class="google-maps">
									<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d50690.26194980397!2d-122.12143953181338!3d37.43376494127794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fa35b186a39fb%3A0x5984eee2a66a9cc2!2sMiddlefield+Rd%2C+Palo+Alto%2C+CA%2C+Stany+Zjednoczone!5e0!3m2!1spl!2spl!4v1407250117753" width="1200" height="600" frameborder="0" style="border:0"></iframe>
								</div>
							</div>		
						</li>

						
					</ul>	

				</div><!--/col-->

			</div><!--/row-->	
				