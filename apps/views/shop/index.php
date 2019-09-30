<?php echo template('shop/header'); echo template('shop/sider');?>
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
						<div class="col-md-12">
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
										<span class="text-white font-thin h1 block">930</span> 
										<span class="text-muted text-xs">产品</span> 
										<span class="bottom text-right w-full"> 
										<i class="fa fa-cloud-upload text-muted m-r-sm"></i>
										</span> 
								</div>
								<div class="col-xs-6">
									<p class="block panel padder-v bg-info item">
										<span class="text-white font-thin h1 block">432</span> <span class="text-muted text-xs">订单</span> <span class="top"> <i class="fa fa-caret-up text-warning m-l-sm m-r-sm"></i>
										</span> 
								
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
					</div>
					<!-- / stats -->
					<div class="row">
						<div class="col-sm-12 connected" >
							<div class="panel panel-success">
								<div class="panel-heading">系统使用说明</div>
								<div class="list-group bg-white">
								<p class="list-group-item">
									1、进入系统后，请先设置店铺，否则无法进入其他页面
								</p>
								<p class="list-group-item">
									2、设置完毕，即可添加商品（商品内容如有敏感内容，系统将会做永久封号处理）
								</p>
								<p class="list-group-item">
									3、简单说一下推广：通过右侧的商城二维码，进入商城，多分享自己的商品到朋友圈或者微信群，不仅可以售出商品，而且自己也会获取合作伙伴的佣金，还有很多玩法需要您自己慢慢去研究。
								</p>
								</div>
							</div>
							<div class="panel panel-success">
								<div class="panel-heading">打赏</div>
								<div class="list-group bg-white">
									<p class="list-group-item">
										不论多少，1毛也是爱，您的支持，是我们永远的动力！
									</p>
									<p class="list-group-item">
										<img alt="" src="<?php echo IMG_PATH.'wechat_pay.jpg';?>">
										<img alt="" src="<?php echo IMG_PATH.'ali_pay.jpg';?>">
									</p>
								</div>
							</div>
							<div class="panel panel-success">
								<div class="panel-heading">定制化联系方式</div>
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
											<a class="h4">免费投票系统</a> <small class="block m-t-xs">系统由 <a href="http://www.1m15.com"><?php echo COMPANY?></a> 研发，本公司拥有最终解释权，侵权必究。 </small>

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

<?php echo template('shop/script');?>
<?php echo template('shop/footer');?>