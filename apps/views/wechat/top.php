<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title><?php echo SYSTEM_NAME;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="author" content="chaituan@126.com">
<link rel="stylesheet" href="<?php echo CSS_PATH."animate.css/animate.css";?>" type="text/css" />
<link rel="stylesheet" href="<?php echo JS_PATH."jquery/bootstrap/dist/css/bootstrap.css";?>" type="text/css" />
  <?php  if(isset($definedcss)){   foreach ($definedcss as $v){?>
	<link type="text/css" href="<?php echo $v.'.css'?>" rel="stylesheet" />
  <?php }}?>
</head>
<body>