<?php echo template('mobile/header');?>
<div class="page order_lists">
	<div class="weui-tab">
            <div class="weui-navbar">
                <a class="weui-navbar__item <?php if(!$xz)echo 'weui-bar__item_on';?>" href="<?php echo site_url('mobile/news/index')?>">全部</a>
                <?php foreach ($cat as $v){?>
                <a class="weui-navbar__item <?php if($xz == $v['id'])echo 'weui-bar__item_on';?>" href="<?php echo site_url('mobile/news/index/id-'.$v['id'])?>" ><?php echo $v['catname'];?></a>
                <?php }?>
            </div>
            <div class="weui-tab__panel" >
            <div class="weui-panel weui-panel_access news_lists"  >
            
            <?php if($newItems){ ?>
            	<div class="weui-panel__bd" >
            <?php	foreach ($newItems as $vs){?>
		                <a href="<?php echo site_url('mobile/news/detail/id-'.$vs['id'])?>" class="weui-media-box weui-media-box_appmsg">
		                    <div class="weui-media-box__hd">
		                        <img class="weui-media-box__thumb" src="<?php echo $vs['thumb'];?>" alt="">
		                    </div>
		                    <div class="weui-media-box__bd">
		                        <h4 class="weui-media-box__title"><?php echo $vs['title'];?></h4>
		                        <p class="weui-media-box__desc"><?php echo format_time($vs['addtime'],'Y-m-d');?></p>
		                    </div>
		                </a>
			<?php }?>
				</div>
			<?php }else{?>
				<div class="text-center" style="margin: 30% 10%">
					<p style="margin-bottom: 5%;color: #999;">居然还没有人上头条</p>
					<p style="margin-bottom: 10%;color: #999;">听说又上新品了(⊙０⊙)</p>
					<p><a href="<?php echo site_url('mobile/mall/index')?>" class="weui-btn weui-btn_plain-primary">走，去商城逛逛</a></p>
				</div>
			<?php }?>
			</div>
            </div>
	</div>
</div>
<div class="hr_70"></div>
<?php echo template('mobile/script');?>
<script type="text/javascript">
$(function(){
	$('body').css('background-color','#fff');
});
</script>
<?php echo template('mobile/footer');?>
