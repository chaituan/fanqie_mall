<?php echo template('mobile/header');?>
<div id="_paypage">
<header>
	<div class="weui-cells order_affirm_address">
			<a class="weui-cell weui-cell_access hasAddress" href="javascript:void(0);">
				<div class="weui-cell__bd">
					管理收货地址
				</div>
				<div class="weui-cell__ft"></div>
			</a>
	</div>
</header>
<a href="<?php echo site_url('mobile/center/index')?>" class="weui-btn weui-btn_primary" style="width: 90%;margin-top: 20px;">返回会员中心</a>
</div>
<?php echo template('mobile/script');?>
<?php echo template('mobile/address');?>
<script src="<?php echo JS_PATH.'mobile/font/iconfont.js'?>"></script>
</div>
</body>
</html>