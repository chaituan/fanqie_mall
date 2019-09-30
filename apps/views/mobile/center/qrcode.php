<?php echo template('mobile/header');?>
<header>
<div class="fanqie_top_bar" >
		<div class="fanqie_top_pull_left" onclick="javascript:history.go(-1);">
		  	<svg class="icon" aria-hidden="true"><use xlink:href="#icon-fanhui"></use></svg>
		</div>
		<div class="fanqie_top_title">我的二维码</div>
</div>
<div class="hr_40"></div>
</header>
<div class="page">
	<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                	<img alt="" src="<?php echo $img;?>" style="width: 100%;">
                </div>
            </div>
    </div>
    <?php if(!$img){?>
    <div class="weui-btn-area">
	    <a href="<?php echo site_url('mobile/center/qrcode')?>" class="weui-btn weui-btn_primary ajaxproxy" 
		proxy='{"method":"get" ,"location":"reload"}' data-loading-text="loading...">生成二维码</a>
	</div>
	<?php }else{?>
	<div class="weui-cells ">
            <div class="weui-cell">
                <div class="weui-cell__bd" style="font-size: 12px;color: #bbb;">
                	过期时间：<?php echo $expire;?>
                </div>
            </div>
    </div>
	<?php }?>
</div>
<?php echo template('mobile/script');?>
<?php echo template('mobile/footer');?>