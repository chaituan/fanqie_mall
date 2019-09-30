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
	<div class="app app-header-fixed ">
		<div class="container w-xxl w-auto-xs" ng-init="app.settings.container = false;">
			<div class="text-center m-b-lg">
				<h1 class="text-shadow text-white">404</h1>
			</div>
			<div class="list-group bg-info auto m-b-sm m-b-lg">
				<a href="<?php if(PREV_URL){ echo PREV_URL;}else{echo HTTP_HOST;}?>" class="list-group-item"> <i class="fa fa-chevron-right text-muted"></i> <i class="fa fa-fw fa-mail-forward m-r-xs"></i> 返回首页
				</a>
			</div>
			<div class="text-center" ng-include="'tpl/blocks/page_footer.html'">
				<p>
					<small class="text-muted"><?php echo COMPANY;?><br>&copy; 2016</small>
				</p>
			</div>
		</div>
	</div>
<?php echo template('admin/script');?>

<?php echo template('admin/footer');?>