<?php echo template('shop/header'); echo template('shop/sider');?>
<!-- content -->
<div id="content" class="app-content animated fadeIn" role="main">
	<div class="app-content-body ">
		<div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="app.settings.asideFolded = false;app.settings.asideDock = false;">
			<!-- main -->
			<div class="col">
				<!-- / main header -->
				<div class="wrapper-md" ng-controller="FlotChartDemoCtrl">
					<div class="row">
						<div class="col-sm-12 connected" >
							<div class="panel panel-success">
								<div class="panel-heading">商城二维码</div>
								<div class="list-group bg-white">
									<div class="list-group-item text-center">
										<p>商城二维码(微信扫码打开)</p>
										<p style="display: inline-block;">
										<img src="<?php echo IMG_PATH.'chaituan.jpg'?>"  style="width: 50%;">
										</p>
									</div>
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
<?php echo template('shop/script');?>
<?php echo template('shop/footer');?>