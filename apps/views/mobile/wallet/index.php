<?php echo template('mobile/header');?>
<header class="wallet_center-header">
	<div class="weui-flex">
		<div class="weui-flex__item text-center" >
			<p  class="wallet_icon">
	            <svg class="icon wallet_icon_s" aria-hidden="true" ><use xlink:href="#icon-yongjin"></use></svg>
			</p>
			<p class="wallet_ktx">可提现金额（元）</p>
			<p class="wallet_money">¥ <?php echo $total;?></p>
		</div>
	</div>
</header>
<div class="page child">
<?php if($total){ ?>
	<div class="weui-cells ">
            <div class="weui-cell weui-cell_access" >
					<div class="weui-cell__bd">
						<p>提现审核（元）</p>
					</div>
					<div class="weui-cell__ft">100</div>
			</div>
			<div class="weui-cell weui-cell_access" >
					<div class="weui-cell__bd">
						<p>已提现（元）</p>
					</div>
					<div class="weui-cell__ft">100</div>
			</div>
			<div class="weui-cell weui-cell_access" >
					<div class="weui-cell__bd">
						<p>总收益（元）</p>
					</div>
					<div class="weui-cell__ft"><?php echo $total;?></div>
			</div>
	</div>
	<div class="weui-btn-area">
	    <a href="<?php echo site_url('mobile/wallet/withdraw_cash')?>" class="weui-btn weui-btn_primary">我要提现</a>
	</div>
<?php }else{?>
	<div>
		<div class="text-center" style="margin: 30% 10%">
			<p style="margin-bottom: 5%;color: #999;">您的钱包空荡荡的</p>
			<p style="margin-bottom: 10%;color: #999;">听说别人的钱包都装不下了(⊙０⊙)</p>
			<p><a href="<?php echo site_url('mobile/center/qrcode')?>" class="weui-btn weui-btn_plain-primary">走，赶紧去挣钱</a></p>
		</div>
	</div>
<?php }?>

</div>
<?php echo template('mobile/script');?>
<?php echo template('mobile/footer');?>