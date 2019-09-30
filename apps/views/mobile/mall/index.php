<?php  $data['definedcss'] = array(CSS_PATH.'mobile/swiper.min'); echo template('mobile/header',$data);?>
<header>
<?php if($banner){?>
	<div class="swiper-container">
	    <div class="swiper-wrapper">
	    	<?php foreach ($banner as $v){?>
		        <div class="swiper-slide">
		        	<img data-src="<?php echo $v['thumb'];?>" style="width: 100%" class="swiper-lazy">
		        </div>
		     <?php }?>
	    </div>
	    <div class="swiper-scrollbar"></div>
	</div>
<?php }?>
</header>
<div class="page ">
	<div class="weui-grids mall-cat-list">
	<?php foreach ($cat as $v){ if($v['enabled']){if($v['isrecommand']){ ?>
	  <a href="<?php echo site_url('mobile/mall/lists/id-'.$v['id']);?>" class="weui-grid">
	    <div class="weui-grid__icon">
	      <img  src="<?php echo $v['thumb'];?>">
	    </div>
	    <p class="weui-grid__label"><?php echo $v['names']?></p>
	  </a>
	<?php }}}?>
	</div>
     
	<div class="weui-cells center-list" style="background-color: #fff;margin-bottom: 10px;">
		<div class="weui-cell weui-cell_access">
			<div class="weui-cell__hd">
				<svg class="icon" aria-hidden="true" style="color: #d81e06;width: 30px;height: 30px;"><use xlink:href="#icon-chaogetoutiao"></use></svg>
			</div>
			<div class="weui-cell__bd"> &nbsp;&nbsp;<a href="<?php echo site_url('mobile/news/detail/id-'.$toutiao['id'])?>"><?php echo str_cut($toutiao['title'], 15);?></a></div></div>
		</div>
	</div>
	
	<div class="weui-grids mall-goods-list" id="wrapper_load" data-page="<?php echo $pagemenu['start'];?>">
		<div id='list'>
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
    </div>
    <?php if($pagemenu['end']){ ?>
	<div id="dianji_load" style="overflow: hidden;">
		<a href="javascript:;" id="dianji_load_click" class="weui-btn weui-btn_default" style="font-size: 14px;margin: 10px;color: #9a9a9a;">点击加载更多...</a>
	</div>
	<div id="dianji_load_wait" style="overflow: hidden;display: none">
	  	<a href="javascript:;" class="weui-btn weui-btn_default weui-btn_loading" style="font-size: 14px;margin: 10px;color: #9a9a9a;"><i class="weui-loading"></i>玩命加载中...</a>
	</div>
	<?php } ?>
</div>
<div style="height: 50px;"></div>
<?php echo template('mobile/script');?>
<script src="<?php echo JS_PATH.'mobile/swiper.min.js'?>"></script>
<script src="<?php echo JS_PATH.'mobile/lazyload.min.js'?>"></script>
<script>
//上拉要执行的方法
function pullUpAction(){
	setTimeout(function(){
		load_ajax({url:"/mobile/mall/goods_ajax",data:{page:$('#wrapper_load').data('page')}});
	},500);
}
//组合输出的列表
function load_list(d){
	var li, i,clas;
	for (i = 0,li = ""; i < d.length; i++) {
		if((i+1)%2==0){clas = 'pull-right'}else{ clas = 'pull-left'}
		li += '<a href="/mobile/mall/detail/id-'+d[i]['id']+'.html" class="weui-grid '+clas+'">' 
			+ '<div class="weui-grid__icon" ><img src="'+ d[i]['thumb'] +'"></div>'
 			+ '<p class="weui-grid__label" >'+ d[i]['names']+'</p>'
			+ '<p class="weui-grid__label" >'
			+ '<span class="pull-left price">￥'+ d[i]['price']+'</span>'
			+ '<span class="pull-right sales">'+ d[i]['sales']+'</span>'
 			+ "</p>"
			+ "</a>";
	}
	$('#list').append(li);
	
}
$(function(){
	var mySwiper = new Swiper ('.swiper-container', {
		  autoplay : 2000,
		  lazyLoading : true,
		  scrollbar:'.swiper-scrollbar',
		  autoplayDisableOnInteraction : false
		});
	$("img.lazy").lazyload({
	    effect : "fadeIn"
	});
});
</script>
<?php echo template('mobile/footer');?>