<?php echo template('admin/header'); echo template('admin/sider');?>
<!-- content -->
<div id="content" class="app-content animated fadeIn" role="main">
	<div class="app-content-body ">
		<div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="app.settings.asideFolded = false;app.settings.asideDock = false;">
			<!-- main -->
			<div class="col">
				<!-- main header -->
				<div class="bg-light lter b-b wrapper-md">
					<div class="row">
						<div class="col-sm-6 col-xs-12">
							<h1 class="m-n font-thin h3 text-black"><?php echo $loginUser['username'];?></h1>
							<small class="text-muted">网站高级管理员</small>
						</div>
					</div>
				</div>
				<!-- / main header -->
				<div class="wrapper-md" ng-controller="FlotChartDemoCtrl">
					<!-- stats -->
					<div class="row">
						<div class="col-md-5">
							<div class="row row-sm text-center">
								<div class="col-xs-6">
									<div class="panel padder-v item">
										<div class="h1 text-info font-thin h1">521</div>
										<span class="text-muted text-xs">会 员</span>
										<div class="top text-right w-full">
											<i class="fa fa-caret-down text-warning m-r-sm"></i>
										</div>
									</div>
								</div>
								<div class="col-xs-6">
									<p class="block panel padder-v bg-primary item">
										<span class="text-white font-thin h1 block">930</span> <span class="text-muted text-xs">产品</span> <span class="bottom text-right w-full"> <i class="fa fa-cloud-upload text-muted m-r-sm"></i>
										</span> </a>
								
								</div>
								<div class="col-xs-6">
									<p class="block panel padder-v bg-info item">
										<span class="text-white font-thin h1 block">432</span> <span class="text-muted text-xs">订单</span> <span class="top"> <i class="fa fa-caret-up text-warning m-l-sm m-r-sm"></i>
										</span> </a>
								
								</div>
								<div class="col-xs-6">
									<div class="panel padder-v item">
										<div class="font-thin h1">129</div>
										<span class="text-muted text-xs">退货</span>
										<div class="bottom">
											<i class="fa fa-caret-up text-warning m-l-sm m-r-sm"></i>
										</div>
									</div>
								</div>
								<div class="col-xs-12 m-b-md">
									<div class="r bg-light dker item hbox no-border">
										<div class="col w-xs v-middle hidden-md">
											<div ng-init="d3_3=[60,40]" ui-jq="sparkline" ui-options="[60,40], {type:'pie', height:40, sliceColors:['#fad733','#fff']}" class="sparkline inline"></div>
										</div>
										<div class="col dk padder-v r-r">
											<div class="text-primary-dk font-thin h1">
												<span>$12,670</span>
											</div>
											<span class="text-muted text-xs">总收入</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-7">
							<div class="panel wrapper">
								<label class="i-switch bg-warning pull-right" ng-init="showSpline=true"> <input type="checkbox" ng-model="showSpline"> <i></i>
								</label>
								<h4 class="font-thin m-t-none m-b text-muted">收入和订单</h4>
								<div ui-jq="plot" ui-refresh="showSpline"
									ui-options="
                        [
                        { data: [ [0,7],[1,6.5],[2,12.5],[3,7],[4,9],[5,6],[6,11],[7,6.5],[8,8],[9,7] ], label:'收入', points: { show: true, radius: 1}, splines: { show: true, tension: 0.4, lineWidth: 1, fill: 0.8 } },
                        { data: [ [0,4],[1,4.5],[2,7],[3,4.5],[4,3],[5,3.5],[6,6],[7,3],[8,4],[9,3] ], label:'订单', points: { show: true, radius: 1}, splines: { show: true, tension: 0.4, lineWidth: 1, fill: 0.8 } }
                        ],
                        {
                        colors: ['#23b7e5', '#7266ba'],
                        series: { shadowSize: 3 },
                        xaxis:{ font: { color: '#a1a7ac' } },
                        yaxis:{ font: { color: '#a1a7ac' }, max:20 },
                        grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#dce5ec' },
                        tooltip: true,
                        tooltipOpts: { content: 'Visits of %x.1 is %y.4',  defaultTheme: false, shifts: { x: 10, y: -25 } }
                        }
                        "
									style="height: 246px"></div>
							</div>
						</div>
					</div>
					<!-- / stats -->
					<!-- service -->
					<div class="panel hbox hbox-auto-xs no-border">
						<div class="col wrapper">
							<i class="fa fa-circle-o text-info m-r-sm pull-right"></i>
							<h4 class="font-thin m-t-none m-b-none text-primary-lt">会员</h4>
							<span class="m-b block text-sm text-muted">每天的统计图</span>
							<div ui-jq="plot" ui-options="
                      [
                      { data: [ [1,5.5],[2,6.5],[3,7],[4,8],[5,7.5],[6,7],[7,6.8],[8,7],[9,7.2],[10,7],[11,6.8],[12,7],[13,2.5],[14,3.5],[15,7],[16,7],[17,6],[18,7],[19,6.8],[20,5],[21,7],[22,8],[23,6.8],[24,7] ], lines: { show: true, lineWidth: 1, fill:true, fillColor: { colors: [{opacity: 0.2}, {opacity: 0.8}] } } }
                      ],
                      {
                      colors: ['#e8eff0'],
                      series: { shadowSize: 3 },
                      xaxis:{ show:false },
                      yaxis:{ font: { color: '#a1a7ac' } },
                      grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#dce5ec' },
                      tooltip: true,
                      tooltipOpts: { content: '%s of %x.1 is %y.4',  defaultTheme: false, shifts: { x: 10, y: -25 } }
                      }
                      " style="height: 240px"></div>
						</div>
					</div>
					<!-- / service -->
					<div class="row">
						<div class="col-sm-12 connected" ui-jq="sortable" ui-options="{items:'.panel', handle:'.panel-heading', connectWith:'.connected'}">
							<div class="panel panel-success">
								<div class="panel-heading">系统信息</div>
								<div class="list-group bg-white">
									<p class="list-group-item">
										<i class="fa fa-fw fa-envelope"></i> chaituan@126.com
									</p>
									<p class="list-group-item">
										<i class="fa fa-fw fa-qq"></i> 158146903
									</p>
									<p class="list-group-item">
										<i class="fa fa-fw fa-phone"></i> 13538436848
									</p>
									<p class="list-group-item">
										<i class="fa fa-fw fa-wechat"></i> chaituan
									</p>
									<p class="list-group-item">
										<i class="fa fa-fw fa-server"></i> <?php echo PHP_OS;?>;
			                      <?php echo strpos($_SERVER['SERVER_SOFTWARE'], 'PHP')===false ? $_SERVER['SERVER_SOFTWARE'].' ; PHP/'.phpversion() : $_SERVER['SERVER_SOFTWARE'];?>
			                      ;<?php echo $sql_version;?>
			                    </p>
								</div>
							</div>
							<div class="panel panel-info">
								<div class="panel-heading">使用协议</div>
								<div class="panel-body">

									<div class="line pull-in"></div>
									<article class="media">
										<div class="pull-left">
											<span class="fa-stack fa-lg"> <i class="fa fa-circle fa-stack-2x text-info"></i> <i class="fa fa-file-o fa-stack-1x text-white"></i>
											</span>
										</div>
										<div class="media-body">
											<a class="h4"><?php echo SYSTEM_NAME;?></a> <small class="block m-t-xs">系统由<?php echo COMPANY?>研发，本公司拥有最终解释权，侵权必究。 </small>

										</div>
									</article>
									<div class="line pull-in"></div>

								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<!-- / main -->
		</div>
	</div>
</div>
<!-- /content -->

<?php echo template('admin/script');?>
<?php echo template('admin/footer');?>