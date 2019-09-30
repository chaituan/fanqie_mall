<?php echo template('mobile/header');?>
<div class="page order_lists">
	<div class="weui-tab">
            <div class="weui-navbar">
                <a class="weui-navbar__item <?php if(!$xz)echo 'weui-bar__item_on';?>" href="<?php echo site_url('mobile/order/lists')?>">全部</a>
                <a class="weui-navbar__item <?php if($xz==1)echo 'weui-bar__item_on';?>" href="<?php echo site_url('mobile/order/lists/id-1')?>" >待支付</a>
                <a class="weui-navbar__item <?php if($xz==2)echo 'weui-bar__item_on';?>" href="<?php echo site_url('mobile/order/lists/id-2')?>">待发货</a>
                <a class="weui-navbar__item <?php if($xz==3)echo 'weui-bar__item_on';?>" href="<?php echo site_url('mobile/order/lists/id-3')?>">待收货</a>
                <a class="weui-navbar__item <?php if($xz==4)echo 'weui-bar__item_on';?>" href="<?php echo site_url('mobile/order/lists/id-4')?>">评价</a>
            </div>
            <div class="weui-tab__panel" >
            
            <?php if($newItems){ foreach ($newItems as $vs){?>
				<div class="weui-cells center-list">
					<div class="weui-cell" >
						<div class="weui-cell__hd">
							订单号：<?php echo $vs['order_no'];?>
						</div>
					</div> 
					<?php foreach ($vs['child'] as $v){?>
					<div class="weui-cell" >
						<div class="weui-cell__hd">
							<img src="<?php echo $v['thumb']?>">
						</div>
						<div class="weui-cell__bd"><p class="title"><?php echo str_cut($v['title'], 30)?></p><p class="sku"><?php echo $v['sku']?>&nbsp;</p></div>
						<div class="weui-cell__ft"><p class="prices"><?php echo '￥'.$v['prices']?></p><p class="num"><?php echo 'X'.$v['num']?></p></div>
					</div> 
					<?php }?>
					<div class="weui-cell" >
						<div class="weui-cell__bd"></div>
						<div class="weui-cell__ft">
							<a href="<?php echo site_url('mobile/order/detail/id-'.$vs['id'])?>" class="weui-btn weui-btn_mini weui-btn_primary">订单详情</a>
							<?php if($vs['state']==1){?>
							<a href="<?php echo site_url('mobile/order/syts/id-'.$vs['id'])?>" class="weui-btn weui-btn_mini weui-btn_warn">支付订单</a>
							<?php }elseif($vs['state']==2){?>
							<a class="weui-btn weui-btn_mini weui-btn_warn">待发货</a>
							<?php }elseif($vs['state']==3){?>
							<a href="<?php echo site_url('mobile/order/affirm_receive/id-'.$vs['id'])?>" class="weui-btn weui-btn_mini weui-btn_warn ajaxproxy" proxy='{"method":"get","tips":"ok","location":"reload"}' data-loading-text="loading...">确认收货</a>
							<?php }elseif($vs['state']==4){?>
							<a href="<?php echo site_url('mobile/order/comment/id-'.$vs['id'])?>" class="weui-btn weui-btn_mini weui-btn_warn">评价</a>
							<?php }?>
						</div>
					</div>
				</div>
			<?php }}else{?>
				<div class="text-center" style="margin: 30% 10%">
					<p style="margin-bottom: 5%;color: #999;">居然还没有订单</p>
					<p style="margin-bottom: 10%;color: #999;">听说又上新品了(⊙０⊙)</p>
					<p><a href="<?php echo site_url('mobile/mall/index')?>" class="weui-btn weui-btn_plain-primary">走，去商城逛逛</a></p>
				</div>
			<?php }?>
            </div>
	</div>
</div>
<div class="hr_70"></div>
<?php echo template('mobile/script');?>
<?php echo template('mobile/footer');?>
