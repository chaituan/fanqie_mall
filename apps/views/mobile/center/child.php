<?php echo template('mobile/header');?>
<div class="page child">
	<div class="weui-tab">
            <div class="weui-navbar">
                <a class="weui-navbar__item <?php if($xz==1)echo 'weui-bar__item_on';?>" href="<?php echo site_url('mobile/center/child/id-1')?>" >合伙人</a>
                <a class="weui-navbar__item <?php if($xz==2)echo 'weui-bar__item_on';?>" href="<?php echo site_url('mobile/center/child/id-2')?>">朋友</a>
            </div>
            <div class="weui-tab__panel" >
            <?php if($items){ ?>
            <div class="weui-cells ">
           	<?php foreach ($items as $vs){ ?>
				
					<div class="weui-cell" >
						<div class="weui-cell__hd"><img src="<?php echo $vs['thumb'];?>" class="img_r50"></div>
						<div class="weui-cell__bd"><p><?php echo $vs['nickname'];?></p>
						<p class="time"><?php echo format_time($vs['addtime']);?></p></div>
						<div class="weui-cell__ft"></div>
					</div>
			<?php } ?>
			</div>
			<?php }else{?>
				<div class="text-center" style="margin: 30% 10%">
					<p style="margin-bottom: 5%;color: #999;">您还没有创建团队</p>
					<p style="margin-bottom: 10%;color: #999;">听说某个团队又挣钱了(⊙０⊙)</p>
					<p><a href="<?php echo site_url('mobile/center/qrcode')?>" class="weui-btn weui-btn_plain-primary">走，赶紧去组建团队</a></p>
				</div>
			<?php }?>
            </div>
	</div>
</div>
<?php echo template('mobile/script');?>
<?php echo template('mobile/footer');?>