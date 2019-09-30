<?php echo template('mobile/header');?>
<?php if(isset($adimg)&&$adimg){?>
<header>
	<div class="slide">
	    <ul>
	        <li>
	            <a href="#"><img class="lazy" src="<?php echo IMG_PATH.'common/noimg.jpg'?>" data-original="<?php echo $adimg;?>" alt=""></a>
	        </li>
	    </ul>
	</div>
</header>
<?php }?>
<div class="page">
	<?php if($cat){?>
		<div class="weui-grids mall-cat-list" >
		<?php foreach ($cat as $v){ if($v['enabled']){if($v['isrecommand']){ ?>
		  <a href="<?php echo site_url('mobile/mall/lists/id-'.$v['id']);?>" class="weui-grid">
		    <div class="weui-grid__icon">
		      <img  src="<?php echo $v['thumb'];?>">
		    </div>
		    <p class="weui-grid__label"><?php echo $v['names']?></p>
		  </a>
		<?php }}}?>
		</div>
	<?php }?>
    
    <?php if($items){?>	
		<div class="weui-grids mall-goods-list">
		<?php foreach ($items as $k=>$v){?>
			<a href="<?php echo site_url('mobile/mall/detail/id-'.$v['id']);?>" class="weui-grid <?php if(($k+1)%2==0){echo 'pull-right';}else{echo 'pull-left';} ?>">
				<div class="weui-grid__icon" >
			      <img class="lazy" src="<?php echo IMG_PATH.'common/noimg.jpg'?>" data-original="<?php echo $v['thumb']?>">
			    </div>
			    <p class="weui-grid__label" >
			    	<?php echo $v['names']?>
			    </p>
			    <p class="weui-grid__label" >
			    	<span class="pull-left price"> ￥<?php echo $v['price']?></span> 
			    	<span class="pull-right sales"><?php echo $v['sales'].'人购买'?></span>
			    </p>
		    </a>
		<?php }?>
	    </div>
    <?php }else{?>
    	<div class="weui-flex m-t-xxl">
			<div class="weui-flex__item text-center" >
				<div class="weui-loadmore weui-loadmore_line">
		            <span class="weui-loadmore__tips">暂无数据</span>
		        </div>
			</div>
		</div>
    <?php }?>
</div>
<div style="height: 50px;"></div>
<?php echo template('mobile/script');?>
<script src="<?php echo JS_PATH.'mobile/lazyload.min.js'?>"></script>
<script>
$(function(){
	$("img.lazy").lazyload({
	    effect : "fadeIn"
	});
});
</script>
<?php echo template('mobile/footer');?>