<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title><?php echo SHOP_NAME;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="author" content="chaituan@126.com">
<link rel="stylesheet" href="<?php echo CSS_PATH."animate.css/animate.css";?>" type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_PATH."font-awesome/css/font-awesome.min.css";?>" type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_PATH."simple-line-icons/css/simple-line-icons.css";?>" type="text/css" />
<link rel="stylesheet" href="<?php echo JS_PATH."jquery/bootstrap/dist/css/bootstrap.min.css";?>" type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_PATH."font.css";?>" type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_PATH."app.css";?>" type="text/css" />
  <?php  if(isset($definedcss)){   foreach ($definedcss as $v){?>
	<link type="text/css" href="<?php echo $v.'.css'?>" rel="stylesheet" />
  <?php }}?>
</head>
<body>
<script type="text/javascript">
var HTTP_HOST = "<?php echo HTTP_HOST;?>";
</script>
	<div class="app app-header-fixed ">
		<header id="header" class="app-header navbar" role="menu">
			<!-- navbar header -->
			<div class="navbar-header bg-dark">
				<button class="pull-right visible-xs dk" ui-toggle-class="show" target=".navbar-collapse">
					<i class="glyphicon glyphicon-cog"></i>
				</button>
				<button class="pull-right visible-xs" ui-toggle-class="off-screen" target=".app-aside" ui-scroll="app">
					<i class="glyphicon glyphicon-align-justify"></i>
				</button>
				<!-- brand -->
				<a href="/shop/center/index" class="navbar-brand text-lt"> <!--           <i class="fa fa-btc"></i> --> <img src="<?php echo IMG_PATH.'adminloginlogo.png';?>" style="max-height: 25px;"> <span class="hidden-folded m-l-xs"><?php echo SHOP_NAME;?></span>
				</a>
				<!-- / brand -->
			</div>
			<!-- / navbar header -->
			<!-- navbar collapse -->
			<div class="collapse pos-rlt navbar-collapse box-shadow bg-white-only">
				<!-- buttons -->
				<div class="nav navbar-nav hidden-xs">
					<a href="#" class="btn no-shadow navbar-btn" ui-toggle-class="app-aside-folded" target=".app"> <i class="fa fa-dedent fa-fw text"></i> <i class="fa fa-indent fa-fw text-active"></i>
					</a> <a href="javascript:void(0);" data-toggle="modal" data-target="#user-info" class="btn no-shadow navbar-btn"> <i class="icon-user fa-fw"></i>
					</a>
				</div>
				<!-- / buttons -->

				<!-- link and dropdown -->
				<!-- <ul class="nav navbar-nav hidden-sm">
					<li class="dropdown pos-stc"><a href="#" data-toggle="dropdown" class="dropdown-toggle"> <span>快捷菜单</span> <span class="caret"></span>
					</a>
						<div class="dropdown-menu wrapper w-full bg-white">
							<div class="row">
								<div class="col-sm-4">
									<div class="m-l-xs m-t-xs m-b-xs font-bold">
										列表 <span class="badge badge-sm bg-success">10</span>
									</div>
									<div class="row">
										<div class="col-xs-6">
											<ul class="list-unstyled l-h-2x">
												<li><a href><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>快捷菜单</a></li>
												<li><a href><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>快捷菜单</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div></li>
				</ul> -->
				<!-- / link and dropdown -->

				<!-- search form -->
				<form class="navbar-form navbar-form-sm navbar-left shift" >
					<div class="form-group">
						<div class="input-group">
							<input type="text" ng-model="selected" typeahead="state for state in states | filter:$viewValue | limitTo:8" class="form-control input-sm bg-light no-border rounded padder" placeholder="Search projects..."> <span class="input-group-btn">
								<button type="button" class="btn btn-sm bg-light rounded">
									<i class="fa fa-search"></i>
								</button>
							</span>
						</div>
					</div>
				</form>
				<!-- / search form -->

				<!-- nabar right -->
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle"> <i class="icon-bell fa-fw"></i> <span class="visible-xs-inline">Notifications</span> <!-- <span class="badge badge-sm up bg-danger pull-right-xs">2</span> -->
					</a> <!-- dropdown -->
						<div class="dropdown-menu w-xl animated fadeInUp">
							<div class="panel bg-white">
								<div class="panel-heading b-light bg-light">
									<strong>You have <span>2</span> notifications
									</strong>
								</div>
								<div class="list-group">
									<a href class="list-group-item"> <span class="clear block m-b-none"> 1.0 initial released<br> <small class="text-muted">1 hour ago</small>
									</span>
									</a>
								</div>
								<div class="panel-footer text-sm">
									<a href class="pull-right"><i class="fa fa-cog"></i></a> <a href="#notes" data-toggle="class:show animated fadeInRight">See all the notifications</a>
								</div>
							</div>
						</div> <!-- / dropdown --></li>
					<li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle clear" data-toggle="dropdown"> <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm"> <img src="<?php echo IMG_PATH.'adminloginlogo.png';?>"> <i class="on md b-white bottom"></i>
						</span> <span class="hidden-sm hidden-md"><?php echo $loginUser['username']?></span> <b class="caret"></b>
					</a> <!-- dropdown -->
						<ul class="dropdown-menu animated fadeInRight w">
							<li><a href='http://www.1m15.com' target="_blank"><span>官方网站</span>
							</a></li>
							<li><a data-toggle="modal" data-target="#modify-password">密码修改</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo site_url('shop/login/logout');?>">安全退出</a></li>
						</ul> <!-- / dropdown --></li>
				</ul>
				<!-- / navbar right -->
			</div>
			<!-- / navbar collapse -->
		</header>
		<!-- / header -->


		<div aria-hidden="false" aria-labelledby="myLargeModalLabel" role="dialog" tabindex="0" class="modal fade" id="user-info">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button aria-label="Close" data-dismiss="modal" class="close" type="button">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">
							<i class="glyphicon glyphicon-user"></i> 当前登陆用户信息
						</h4>
					</div>
					<div class="modal-body">
						<p>用户名：<?php echo $loginUser['username']?></p>
						<p>创建时间：<?php echo date('Y-m-d H:i:s',$loginUser['add_time'])?></p>
						<p>最后登陆时间：<?php echo date('Y-m-d H:i:s',$loginUser['last_login_time'])?></p>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>

		<div aria-hidden="false" aria-labelledby="myLargeModalLabel" role="dialog" tabindex="0" class="modal fade" id="modify-password">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button aria-label="Close" data-dismiss="modal" class="close" type="button">
							<span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title">
							<i class="glyphicon glyphicon-lock"></i> 修改密码
						</h4>
					</div>
					<div class="modal-body">
						<div role="alert" id="password-alert" class="alert alert-danger alert-dismissible fade in" style="display: none;">
							<strong id="password-error-message"></strong>
						</div>

						<form id="pass-modify-form" autocomplete="off">
							<div class="form-group">
								<label>原密码</label> <input type="password" class="form-control" name="oldpass" placeholder="原密码" required>
							</div>
							<div class="form-group">
								<label>新密码</label> <input type="password"  class="form-control" min-length="6"  name="password" id="one_pwd" placeholder="新密码" required>
							</div>
							<div class="form-group">
								<label>确认密码</label> <input type="password" class="form-control" min-length="6" name="passwords" dtype="repass" for-password="one_pwd"  placeholder="确认密码" required>
							</div>
							<a href="<?php echo site_url("shop/center/password")?>" class="btn btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"pass-modify-form", "method":"post", "location":"<?php echo site_url('shop/login/logout')?>"}'>保存修改</a>
						</form>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
