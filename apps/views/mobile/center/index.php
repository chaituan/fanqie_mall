<?php echo template('mobile/header');?>

<header class="center-header">
	<div class="weui-flex">
		<div class="weui-flex__item text-center" >
			<img alt="" src="<?php echo $U['thumb'];?>" class="center-header-thumb">
		</div>
		<div class="weui-flex__item">
			<p class="center-header-name"><?php echo $U['nickname'];?></p>
			<a href="#" class="center-header-lv">
			  游客<svg class="icon" aria-hidden="true"><use xlink:href="#icon-gengduo"></use></svg>
			</a>
		</div>
		<div class="weui-flex__item">
			
		</div>
	</div>
</header>
<div class="page">
	<div class="weui-grids grids-small center-order-icon">
	  <a href="<?php echo site_url('mobile/order/lists/id-1');?>" class="weui-grid">
	    <div class="weui-grid__icon">
		    <span style="display: inline-block;position: relative;">
		      <svg class="icon" aria-hidden="true"><use xlink:href="#icon-daifukuan"></use></svg>
		      <?php if($order['pay']){?><span class="weui-badge" style="position: absolute;top: -5px;right: -13px;"><?php echo $order['pay']?></span><?php }?>
		    </span>
	    </div>
	    <p class="weui-grid__label">待付款</p>
	  </a>
	  <a href="<?php echo site_url('mobile/order/lists/id-2');?>" class="weui-grid js_grid">
	    <div class="weui-grid__icon">
	      <svg class="icon" aria-hidden="true"><use xlink:href="#icon-daifahuo"></use></svg>
	    </div>
	    <p class="weui-grid__label">待发货</p>
	  </a>
	  <a href="<?php echo site_url('mobile/order/lists/id-3');?>" class="weui-grid js_grid">
	    <div class="weui-grid__icon">
		    <span style="display: inline-block;position: relative;">
		      <svg class="icon" aria-hidden="true"><use xlink:href="#icon-daishouhuo"></use></svg>
		      <?php if($order['receive']){?><span class="weui-badge" style="position: absolute;top: -5px;right: -13px;"><?php echo $order['receive'];?></span><?php }?>
	      	</span>
	    </div>
	    <p class="weui-grid__label">待收货</p>
	  </a>
	  <a href="<?php echo site_url('mobile/order/lists/id-4');?>" class="weui-grid js_grid">
	    <div class="weui-grid__icon">
	    	<span style="display: inline-block;position: relative;">
	      		<svg class="icon" aria-hidden="true"><use xlink:href="#icon-daipingjia"></use></svg>
	      		<?php if($order['comment']){?><span class="weui-badge" style="position: absolute;top: -5px;right: -13px;"><?php echo $order['comment'];?></span><?php }?>
			</span>	    
	    </div>
	    <p class="weui-grid__label">待评价</p>
	  </a>
	</div>

	<div class="weui-cells center-list">
		<?php if($config['user_is_fx']){?>
		<a class="weui-cell weui-cell_access" href="<?php echo site_url('mobile/center/child/id-1');?>">
			<div class="weui-cell__hd">
				<svg class="icon" aria-hidden="true"><use xlink:href="#icon-gongsi"></use></svg>
			</div>
			<div class="weui-cell__bd"><p><?php echo $config['user_fx_name'];?></p></div>
			<div class="weui-cell__ft"></div>
		</a>
		<a class="weui-cell weui-cell_access" href="<?php echo site_url('mobile/wallet/index')?>">
			<div class="weui-cell__hd">
				<svg class="icon" aria-hidden="true"><use xlink:href="#icon-fanli"></use></svg>
			</div>
			<div class="weui-cell__bd"><p>我的钱包</p></div>
			<div class="weui-cell__ft"></div>
		</a>
		<a class="weui-cell weui-cell_access" href="<?php echo site_url('mobile/center/qrcode');?>">
			<div class="weui-cell__hd">
				<svg class="icon" aria-hidden="true"><use xlink:href="#icon-erweima"></use></svg>
			</div>
			<div class="weui-cell__bd"><p>我的二维码</p></div>
			<div class="weui-cell__ft"></div>
		</a>
		<?php }?>
	</div>
	<div class="weui-cells center-list">
		<a class="weui-cell weui-cell_access" href="<?php echo site_url('mobile/center/edit_user')?>">
			<div class="weui-cell__hd">
				<svg class="icon" aria-hidden="true"><use xlink:href="#icon-gerenziliao1"></use></svg>
			</div>
			<div class="weui-cell__bd"><p>我的资料</p></div>
			<div class="weui-cell__ft"></div>
		</a>
		<a class="weui-cell weui-cell_access" href="<?php echo site_url('mobile/order/lists')?>">
			<div class="weui-cell__hd">
				<svg class="icon" aria-hidden="true"><use xlink:href="#icon-dingdan"></use></svg>
			</div>
			<div class="weui-cell__bd"><p>我的订单</p></div>
			<div class="weui-cell__ft"></div>
		</a> 
		<!-- <a class="weui-cell weui-cell_access" href="javascript:;">
			<div class="weui-cell__hd">
				<svg class="icon" aria-hidden="true"><use xlink:href="#icon-zuji"></use></svg>
			</div>
			<div class="weui-cell__bd"><p>我的收藏</p></div>
			<div class="weui-cell__ft"></div>
		</a> -->
		<a class="weui-cell weui-cell_access" href="<?php echo site_url('mobile/address/index')?>">
			<div class="weui-cell__hd">
				<svg class="icon" aria-hidden="true"><use xlink:href="#icon-dizhi"></use></svg>
			</div>
			<div class="weui-cell__bd"><p>收货地址</p></div>
			<div class="weui-cell__ft"></div>
		</a>
	</div>
</div>
<?php echo template('mobile/script');?>
<?php echo template('mobile/footer');?>