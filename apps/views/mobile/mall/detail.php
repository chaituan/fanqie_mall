<?php  $data['definedcss'] = array(CSS_PATH.'mobile/swiper.min'); echo template('mobile/header',$data);?>
<header>
	<div class="swiper-container">
	    <div class="swiper-wrapper">
	    	<?php $lbthumb = explode(',', $item['thumb_arr']); foreach ($lbthumb as $v){?>
		        <div class="swiper-slide"><img data-src="<?php echo $v;?>" style="width: 100%" class="swiper-lazy"></div>
		     <?php }?>
	    </div>
	    <div class="swiper-scrollbar"></div>
	</div>
</header>
<div class="page mall-goods-detail">
	<div class="weui-cells">
            <div class="weui-cell" >
                <div class="weui-cell__bd">
                    <p id="names"><?php echo $item['names'];?></p>
                </div>
            </div>
            <div class="weui-cell " >
                <div class="weui-cell__bd price" id='price'>￥<?php echo $item['price'];?></div>
                <div class="weui-cell__ft">
                	<svg class="icon" aria-hidden="true"><use xlink:href="#icon-shoucang"></use></svg>
                </div>
            </div>
            <input type="hidden" id="shopid" value="<?php echo $item['shopid'];?>">
            <input type="hidden" id="gid" value="<?php echo $item['id'];?>">
        	<div class="weui-cell three" >
                <div class="weui-flex__item "><div class="placeholder">包邮</div></div>
	            <div class="weui-flex__item text-center"><!-- <div class="placeholder">销量</div> --></div>
	            <div class="weui-flex__item text-right"><div class="placeholder" id='stock'>库存<?php echo $item['stock'];?>件</div></div>
            </div>
	</div>
	<div class="weui-cells">
            <a class="weui-cell weui-cell_access" href="javascript:;">
                <div class="weui-cell__bd sku">
                    	选择：规格
                </div>
                <div class="weui-cell__ft"></div>
            </a>
	</div>
	<div class="weui-tab">
            <div class="weui-navbar">
                <a class="weui-navbar__item weui-bar__item_on" data-id='1' >商品详情</a>
                <a class="weui-navbar__item" data-id='2'>用户评价</a>
            </div>
            <div class="weui-tab__panel" >
				<div  id='tab_1'>
				<?php echo $item['content'];?>
				</div>
				<div  id='tab_2' class="weui_panel" style="display: none;">
				<?php if($comment_items){?>
					<div id="wrapper_load" data-page="<?php echo $pagemenu['start'];?>">  
					  <div class="weui-cells" id='list'>
			           	<?php foreach ($comment_items as $vs){ ?>
								<div class="weui-cell" >
									<div class="weui-cell__hd"><img src="<?php echo $vs['thumb'];?>" class="img_r40"></div>
									<div class="weui-cell__bd">
									<p class="nickname"><?php echo $vs['nickname'];?></p>
									<p class="content"><?php echo $vs['content'];?></p>
									</div>
								</div>
						<?php } ?>
					  </div>
					</div> 
					<?php if($pagemenu['end']){ ?>
					<div id="dianji_load" style="overflow: hidden;">
						<a href="javascript:;" id="dianji_load_click" class="weui-btn weui-btn_default" style="font-size: 14px;margin: 10px;color: #9a9a9a;">点击加载更多...</a>
					</div>
					<div id="dianji_load_wait" style="overflow: hidden;display: none">
					  	<a href="javascript:;" class="weui-btn weui-btn_default weui-btn_loading" style="font-size: 14px;margin: 10px;color: #9a9a9a;"><i class="weui-loading"></i>玩命加载中...</a>
					</div>
					<?php }}else{ ?>
					<div class="text-center p-tb-10 no_data">暂无数据</div>
					<?php }?>
				</div>
            </div>
	</div>
</div>
<div class="hr_70"></div>
<?php echo template('mobile/script');?>
<script src="<?php echo JS_PATH.'mobile/swiper.min.js'?>"></script>
<script src="<?php echo JS_PATH.'mobile/lazyload.min.js'?>"></script>
<script>
//上拉要执行的方法
function pullUpAction(){
	setTimeout(function(){
		load_ajax({url:"/mobile/mall/detail_comment",data:{page:$('#wrapper_load').data('page'),gid:$('#gid').val()}});
	},500);
}
//组合输出的列表
function load_list(d){
	var li, i;
	for (i = 0,li = ""; i < d.length; i++) {
		li += '<div class="weui-cell" >' 
			+ '<div class="weui-cell__hd"><img src="'+ d[i]['thumb'] +'" class="img_r40"></div>'
 			+ '<div class="weui-cell__bd">'
			+ '<p class="nickname">'+ d[i]['nickname']+'</p>'
			+ '<p class="content">'+ d[i]['content']+'</p>'
 			+ "</div>"
			+ "</div>";
	}
	$('#list').append(li);
}
$(function(){
	var mySwiper = new Swiper ('.swiper-container', {autoplay : 2000,lazyLoading : true,scrollbar:'.swiper-scrollbar',autoplayDisableOnInteraction : false});
	$("img.lazy").lazyload({effect : "fadeIn"});
	//tab
    $('.weui-navbar__item').on('click', function () {
       $(this).addClass('weui-bar__item_on').siblings('.weui-bar__item_on').removeClass('weui-bar__item_on');
       if($(this).data('id')==1){
           $('#tab_1').show();$('#tab_2').hide();
       }else{
    	   $('#tab_2').show();$('#tab_1').hide();
       }
    });

	//sku的隐藏和显示
	var $iosActionsheet = $('#iosActionsheet');//sku层
	var $iosMask = $('#iosMask');//遮罩层
	$iosMask.on('click', hideActionSheet);
	$('#iosActionsheetCancel').on('click', hideActionSheet);
	
	function hideActionSheet() {
		$iosActionsheet.removeClass('weui-actionsheet_toggle');
		$('.goods_sku .header img').css("margin-top",'0');
		$iosMask.fadeOut(200);
	}
	$(".showIOSActionSheet").on("click", function(){
		if($(this).data('id') === 1){
			$('#sub_1').show();$('#sub_2').hide();
		}else{
			$('#sub_1').hide();$('#sub_2').show();
		}
		$iosActionsheet.addClass('weui-actionsheet_toggle');
		$('.goods_sku .header img').css("margin-top",'-30px');
		$iosMask.fadeIn(200);
	});
	//加减
	function upDownOperation(element){
	        var _input = element.parent().find('input'),_value = _input.val(),_step = _input.attr('data-step') || 1;
	        //检测当前操作的元素是否有disabled，有则去除
	        element.hasClass('disabled') && element.removeClass('disabled');
	        //检测当前操作的元素是否是操作的添加按钮（.input-num-up）‘是’ 则为加操作，‘否’ 则为减操作
	        if ( element.hasClass('weui-number-plus') ){
	            var _new_value = parseInt( parseFloat(_value) + parseFloat(_step) ),_max = _input.attr('data-max') || false,_down = element.parent().find('.weui-number-sub');
	            //若执行‘加’操作且‘减’按钮存在class='disabled'的话，则移除‘减’操作按钮的class 'disabled'
	            _down.hasClass('disabled') && _down.removeClass('disabled');
	            if (_max && _new_value >= _max) {_new_value = _max;element.addClass('disabled');}
	        } else {
	            var _new_value = parseInt( parseFloat(_value) - parseFloat(_step) ),_min = _input.attr('data-min') || false, _up = element.parent().find('.weui-number-plus');
	            //若执行‘减’操作且‘加’按钮存在class='disabled'的话，则移除‘加’操作按钮的class 'disabled'
	            _up.hasClass('disabled') && _up.removeClass('disabled');
	            if (_min && _new_value <= _min) {_new_value = _min;element.addClass('disabled');}
	        }
	        _input.val( _new_value );
	}
	$('.weui-number-plus').click(function(){upDownOperation( $(this) );});
	$('.weui-number-sub').click(function(){upDownOperation( $(this) );});
});
</script>
<!-- 弹出规格选择   明天要判断当后台关闭了规格 但是规格还有值的情况下-->
<div class="weui-mask" id="iosMask" style="display: none"></div>
<div class="weui-actionsheet goods_sku" id="iosActionsheet">
			<div id="goods_img" class="hidden"><img src="<?php echo $item['thumb'];?>"></div>
            <div class="weui-actionsheet__menu" id="sku">
            	<input type="hidden"  id="goods_id" value="<?php echo $item['id']?>">
            	<?php echo template('mobile/sku');?>
            </div>
</div>
<div class="weui-tab goods_footer" style="bottom: 0;width: 100%;position: fixed;height: 0;z-index: 510">
	<div class="weui-tabbar footer">
	                <a href="<?php echo site_url('mobile/mall/index')?>" class="weui-tabbar__item">
	                    <span style="display: inline-block;position: relative;">
	                        <svg class="icon" aria-hidden="true"><use xlink:href="#icon-dianpu"></use></svg>
	                    </span>
	                    <p class="weui-tabbar__label">商城</p>
	                </a>
	                <a href="<?php echo site_url('mobile/cart/index')?>" class="weui-tabbar__item">
	                	<span style="display: inline-block;position: relative;">
	                        <svg class="icon" aria-hidden="true"><use xlink:href="#icon-gouwuche"></use></svg>
	                        <?php if($cart_num){?><span class="weui-badge" style="position: absolute;top: -2px;right: -13px;"><?php echo $cart_num;?></span><?php }?>
	                    </span>
	                    <p class="weui-tabbar__label">购物车</p>
	                </a>
	                <a href="javascript:void(0);" class="weui-tabbar__item push_car showIOSActionSheet" data-id='1'>加入购物车</a>
	                <a href="javascript:void(0);" class="weui-tabbar__item buy showIOSActionSheet" data-id="2">立即购买</a>
	</div>
</div>
<script src="<?php echo JS_PATH.'mobile/font/iconfont.js'?>"></script>
</div><!-- end container -->
</body>
</html>