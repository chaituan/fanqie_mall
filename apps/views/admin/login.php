<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title><?php echo SITE_NAME?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="author" content="chaituan@126.com">
<link rel="stylesheet" href="<?php echo CSS_PATH."animate.css/animate.css";?>" type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_PATH."font-awesome/css/font-awesome.min.css";?>" type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_PATH."simple-line-icons/css/simple-line-icons.css";?>" type="text/css" />
<link rel="stylesheet" href="<?php echo JS_PATH."jquery/bootstrap/dist/css/bootstrap.css";?>" type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_PATH."font.css";?>" type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_PATH."app.css";?>" type="text/css" />
</head>
<body>
	<div class="app app-header-fixed" style="padding-top: 10%;">
		<div class="container w-xxl w-auto-xs animated fadeInRight" ng-controller="SigninFormController" ng-init="app.settings.container = false;">
			<p class="text-center">
				<img src="<?php echo IMG_PATH.'adminloginlogo.png';?>">
			</p>
			<a class="navbar-brand block m-t"><?php echo SYSTEM_NAME;?></a>
			<div class="m-b-lg">
				<form id="loginform" class="form-validation">
					<div class="text-danger wrapper text-center" ng-show="authError"></div>
					<div class="list-group list-group-sm">
						<div class="list-group-item">
							<input type="text" placeholder="帐号" name="username" class="form-control no-border" required>
						</div>
						<div class="list-group-item">
							<input type="password" placeholder="密码" name="password" class="form-control no-border" required>
						</div>
					</div>
					<a class="btn btn-lg btn-primary btn-block ajaxproxy" id="login" href="<?php echo site_url("adminct/login/add")?>" proxy='{"method":"post", "formId":"loginform","location":"<?php echo site_url("adminct/manager/index")?>"}'> 登 录 </a>
					<div class="line line-dashed"></div>
				</form>
			</div>
			<div class="text-center" ng-include="'tpl/blocks/page_footer.html'">
				<p>
					<small class="text-muted"><?php echo COMPANY;?><br>&copy; 2016</small>
				</p>
			</div>
		</div>
	</div>
<?php echo template('admin/script');?>
<script type="text/javascript">
$(function(){
	document.onkeydown=function(event){
		var e=event||window.event;
		var keyCode=e.keyCode||e.which;//e.which 兼容FF
			if (keyCode ==13) {   
				e.returnValue=false;
				e.cancel = true;
				$('#login').click();
			}
		}
});
</script>
</body>
</html>