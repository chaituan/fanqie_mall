<?php echo template('mobile/header');?>
<div id="_paypage">
<header>
	<div class="weui-cells order_affirm_address">
			<a class="weui-cell weui-cell_access hasAddress" href="javascript:void(0);">
			<?php if($aitem){?>
				<div class="weui-cell__hd">
					<svg class="icon" aria-hidden="true"><use xlink:href="#icon-dizhi"></use></svg>
				</div>
				<div class="weui-cell__bd">
					<p class="names"><span class="cur_name"><?php echo $aitem['names']?></span>   &nbsp;&nbsp;&nbsp;  <span class="cur_phone"><?php echo $aitem['mobile']?></span></p>
					<p class="address cur_address"><?php echo $aitem['province'].$aitem['city'].$aitem['district'].$aitem['detailed']?> </p>
				</div>
			<?php }else{?>
				<div class="weui-cell__bd no_add">
					请选择收货地址
				</div>
				<div class="weui-cell__hd ok_add" style="display: none">
					<svg class="icon" aria-hidden="true"><use xlink:href="#icon-dizhi"></use></svg>
				</div>
				<div class="weui-cell__bd ok_add" style="display: none">
					<p class="names"><span class="cur_name"></span>   &nbsp;&nbsp;&nbsp;  <span class="cur_phone"></span></p>
					<p class="address cur_address"></p>
				</div>
			<?php }?>
				<div class="weui-cell__ft"></div>
			</a>
	</div>
</header>
<form id="order_add">
<div class="page order_affirm">
<?php foreach ($items as $k=>$v){?>
	<div class="weui-cells">
		<?php foreach ($v as $item){?>
		<div class="weui-cell" >
			<div class="weui-cell__hd">
				<img src="<?php echo $item['thumb'];?>" >
			</div>
			<div class="weui-cell__bd">
				<p class="names"><?php echo $item['names'];?></p>
				<p class="sku"><?php echo $item['options'].'&nbsp;';?> </p>
			</div>
			<div class="weui-cell__ft">
				<p class="price">￥<?php echo $item['price'];?></p>
				<p class='num'><?php echo 'X'.$item['num'];?></p>
			</div>
		</div>
		<?php }?>
		<div class="weui-cell" >
			<div class="weui-cell__hd">配送方式</div>
			<div class="weui-cell__bd"></div>
			<div class="weui-cell__ft">
				快递发货
			</div>
		</div>
		<div class="weui-cell weui-cell_access" >
			<div class="weui-cell__hd">发票信息</div>
			<div class="weui-cell__bd"></div>
			<div class="weui-cell__ft">无</div>
		</div>
		<div class="weui-cell" >
			<div class="weui-cell__hd">买家留言</div>
			<div class="weui-cell__bd">
				<input type="text" class="weui-input" name="data[<?php echo $k;?>][message]" placeholder="不能超过45个汉字">
			</div>
		</div>
	</div>
<?php }?>
	<div class="weui-cells">
		<div class="weui-cell weui-cell_access" >
			<div class="weui-cell__hd">优惠券</div>
			<div class="weui-cell__bd"></div>
			<div class="weui-cell__ft">无</div>
		</div>
		<div class="weui-cell weui-cell_access" >
			<div class="weui-cell__hd">积分</div>
			<div class="weui-cell__bd"></div>
			<div class="weui-cell__ft">无</div>
		</div>
	</div>
</div>
<input type="hidden" name="data[add][buy_name]" id="buy_name" value="<?php echo $aitem['names']?>" cname="收货人姓名" required>
<input type="hidden" name="data[add][buy_mobile]" id="buy_mobile" value="<?php echo $aitem['mobile']?>" cname="收货人手机" required>
<input type="hidden" name="data[add][buy_address]" id="buy_address" value="<?php echo $aitem['province'].$aitem['city'].$aitem['district'].$aitem['detailed']?>" cname="收货人地址" required>
</form>
<div class="hr_50"></div>
<div class="weui-tab order_affirm_footer" style="bottom: 0;width: 100%;position: fixed;height: 0;z-index: 510">
	<div class="weui-tabbar footer">
					<a href="<?php echo site_url('mobile/mall/index')?>" class="weui-tabbar__item">
	                    <span style="display: inline-block;position: relative;">
	                        <svg class="icon" aria-hidden="true"><use xlink:href="#icon-dianpu"></use></svg>
	                    </span>
	                    <p class="weui-tabbar__label">首页</p>
	                </a>
	                <div href="<?php echo site_url('mobile/mall/index')?>" class="weui-tabbar__item heji">
	                   	合计： <span id="price_total">￥<?php echo $total;?></span>
	                </div>
	                <a href="<?php echo site_url('mobile/order/create_order')?>" class="weui-tabbar__item buy ajaxproxy" data-id="2" proxy='{"formId":"order_add", "method":"post" ,"location":"<?php echo site_url('mobile/order/syt')?>"}' data-loading-text="loading...">提交订单</a>
	</div>
</div>
</div>
<?php echo template('mobile/script');?>
<?php echo template('mobile/address');?>
<script src="<?php echo JS_PATH.'mobile/font/iconfont.js'?>"></script>
</div><!-- end container -->
</body>
</html>