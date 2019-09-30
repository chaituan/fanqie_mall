<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<title><?php echo MOBILE_NAME;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no,email=no,adress=no">
<meta name="author" content="chaituan@126.com">

<link rel="stylesheet" href="<?php echo CSS_PATH."mobile/weui.min.css";?>" type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_PATH."mobile/style.css";?>" type="text/css" />
  <?php  if(isset($definedcss)){   foreach ($definedcss as $v){?>
	<link type="text/css" href="<?php echo $v.'.css'?>" rel="stylesheet" />
  <?php }}?>
</head>
<body ontouchstart>
<div class="container " id="container" >
