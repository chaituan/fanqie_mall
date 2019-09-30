<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<title><?php echo SYSTEM_NAME;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="chaituan@126.com">
<link rel="stylesheet" href="<?php echo CSS_PATH."mobile/weui.min.css";?>" type="text/css" />
<link rel="stylesheet" href="<?php echo CSS_PATH."mobile/style.css";?>" type="text/css" />
</head>
<body style="background-color: #fff;">
<div class="weui-msg">
        <div class="weui-msg__icon-area">
         <?php echo $tipsico;?>
         </div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title"><?php echo $msg; ?></h2>
           <!--  <p class="weui-msg__desc">内容详情，可根据实际需要安排，如果换行则不超过规定长度，居中展现<a href="javascript:void(0);">文字链接</a></p> -->
        </div>
        <div class="weui-msg__opr-area">
            <p class="weui-btn-area">
            <?php if($url_forward=='goback' || $url_forward=='') { if($show_btn){ ?>
				<button type="button" class="weui-btn weui-btn_primary" onclick="javascript:history.back();">返回上一步</button>
				<button type="button" class="weui-btn weui-btn_default" onclick="window.location.href='<?php echo $index;?>'">返回首页</button>
			<?php }} elseif($url_forward) {?>
				<?php echo ($ms/1000);?> 秒后自动返回，如没有跳转，请：<a href="<?php echo $url_forward?>" style="color: #777;">点击这里</a>
				<script language="javascript">setTimeout(function(){window.location.href='<?php echo $url_forward?>';},<?php echo $ms?>);</script>
			<?php }?>
            </p>
        </div>
        <div class="weui-msg__extra-area">
            <div class="weui-footer">
<!--                 <p class="weui-footer__links"> -->
<!--                     <a href="javascript:void(0);" class="weui-footer__link">底部链接文本</a> -->
<!--                 </p> -->
                <p class="weui-footer__text">Copyright © 2008-2017 襄阳市番茄网络科技有限公司</p>
            </div>
        </div>
</div>
</body>
</html>