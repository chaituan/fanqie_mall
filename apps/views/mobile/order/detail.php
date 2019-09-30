<?php echo template('mobile/header');?>
<header>
	<div class="weui-cells" style="margin: -1px 0 15px 0;">
			<div class="weui-cell">
				<div class="weui-cell__bd">
					订单号：<?php echo $newItems['item']['order_no'];?>
				</div>
				<div class="weui-cell__ft" style="color: #ff547b;"><?php if($newItems['item']['state']==1){?>
							待支付
							<?php }elseif($newItems['item']['state']==2){?>
							待发货
							<?php }elseif($newItems['item']['state']==3){?>
							待收货
							<?php }elseif($newItems['item']['state']==4){?>
							待评价
							<?php }?>
				</div>
			</div>
	</div>
	<div class="weui-cells order_affirm_address" style="padding: 0;">
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<svg class="icon" aria-hidden="true"><use xlink:href="#icon-dizhi"></use></svg>
				</div>
				<div class="weui-cell__bd">
					<p class="names"><span class="cur_name"><?php echo $newItems['item']['name']?></span>   &nbsp;&nbsp;&nbsp;  <span class="cur_phone"><?php echo $newItems['item']['mobile']?></span></p>
					<p class="address cur_address"><?php echo $newItems['item']['address'];?> </p>
				</div>
			</div>
	</div>
</header>
<div class="page order_affirm">
	<div class="weui-cells">
		<?php foreach ($newItems['child'] as $item){?>
		<a class="weui-cell" href="<?php echo site_url('mobile/mall/detail/id-'.$item['gid'])?>">
			<div class="weui-cell__hd">
				<img src="<?php echo $item['thumb'];?>" >
			</div>
			<div class="weui-cell__bd">
				<p class="names"><?php echo $item['title'];?></p>
				<p class="sku"><?php echo $item['sku'].'&nbsp;';?> </p>
			</div>
			<div class="weui-cell__ft">
				<p class="price">￥<?php echo $item['prices'];?></p>
				<p class='num'><?php echo 'X'.$item['num'];?></p>
			</div>
		</a>
		<?php }?>
		<div class="weui-cell" >
			<div class="weui-cell__hd">快递公司</div>
			<div class="weui-cell__bd"></div>
			<div class="weui-cell__ft"><?php echo $newItems['item']['exp_company'];?></div>
		</div>
		<a class="weui-cell weui-cell_access" <?php if($newItems['item']['exp_company']){ ?> href="https://m.kuaidi100.com/index_all.html?type=<?php echo $newItems['item']['exp_company'];?>&postid=<?php echo $newItems['item']['exp_no'];?>&callbackurl=<?php echo HTTP_HOST.$_SERVER['REQUEST_URI'];?>" <?php }?>>
			<div class="weui-cell__hd">快递单号</div>
			<div class="weui-cell__bd"></div>
			<div class="weui-cell__ft"><?php echo $newItems['item']['exp_no'];?></div>
		</a>
		<div class="weui-cell" >
			<div class="weui-cell__hd">买家留言</div>
			<div class="weui-cell__bd">
				<?php echo $newItems['item']['message'];?>
			</div>
		</div>
	</div>
	<div class="weui-cells">
		<div class="weui-cell" >
			<div class="weui-cell__bd">商品总额</div>
			<div class="weui-cell__ft" style="color: #ff547b;font-weight: bold;">￥<?php echo $newItems['item']['price'];?></div>
		</div>
		<div class="weui-cell" >
			<div class="weui-cell__bd"></div>
			<div class="weui-cell__ft" style="font-size: 12px;">订单创建时间：<?php echo format_time($newItems['item']['addtime']);?></div>
		</div>
	</div>
</div>
<?php echo template('mobile/footer');?>