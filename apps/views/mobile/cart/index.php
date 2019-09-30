<?php echo template('mobile/header');?>
<?php if($newitems){?>
<header>
	<div class="fanqie_top_bar" >
			<div class="fanqie_top_pull_left" onclick="history.go(-1);">
			  	<svg class="icon" aria-hidden="true"><use xlink:href="#icon-fanhui"></use></svg>
			</div>
			<div class="fanqie_top_title">购物车</div>
	</div>
    <div style="height: 40px;"></div>
</header>
<div class="cart order_affirm">
<form id="F_ListForms" >
<?php foreach ($newitems as $ks=>$items){?>
	<div class="weui-cells weui-cells_checkbox">
	<?php $i=0;foreach ($items as $k=>$v){?>
		<div class="weui-cell" >
			<div class="weui-cell__hd">
				<label class="weui-check__label" for="<?php echo 's'.$ks.$i; ?>">
				 	<input class="weui-check cart_check" name="ids[]" id="<?php echo 's'.$ks.$i; ?>" value="<?php echo $k;?>" checked="checked" type="checkbox" data-total="<?php echo $v['subtotal'];?>">
                    <i class="weui-icon-checked"></i>
				</label>
            </div>
			<div class="weui-cell__hd">
				<img src="<?php echo $v['options']['thumb'];?>" >
			</div>
			<div class="weui-cell__bd">
				<p class="names"><?php echo $v['name'];?></p>
				<p class="sku"><?php echo $v['options']['options'];?> &nbsp;</p>
			</div>
			<div class="weui-cell__ft">
				<p class="price">￥<?php echo $v['price'];?></p>
				<p class='num'><?php echo 'X'.$v['qty'];?></p>
			</div>
		</div>
		<p class="edit_del text-right"><a href="javascript:void(0);" data-num="<?php echo $v['qty'];?>" data-cid="<?php echo $k;?>"  class="showIOSActionSheet">编辑</a>
		<a href="<?php echo site_url('mobile/cart/del/id-'.$k)?>" class="ajaxproxy" proxy='{"method":"get" ,"tips":"ok","location":"reload"}' data-loading-text="删除">删除</a></p>
	<?php $i++;}?>
	</div>
<?php }?>
</form>
</div>
<div class="hr_70"></div>
<div class="weui-tab order_affirm_footer" style="bottom: 0;width: 100%;position: fixed;height: 0;z-index: 510">
	<div class="weui-tabbar footer cart">
				<div  class=" weui-tabbar__item weui-cells_checkbox">
                   	<label class="weui-check__label" for="check-all-cart">全选
					 	<input class="weui-check" name="checkbox1" id="check-all-cart" checked="checked" type="checkbox">
	                    <i class="weui-icon-checked"></i>
					</label>
                </div>
                <div href="<?php echo site_url('mobile/mall/index')?>" class="weui-tabbar__item heji">
                   	合计： ￥<span id="price_total"><?php echo $total['cart_total']?></span>
                </div>
                <a href="<?php echo site_url('mobile/order/save_cart')?>" class="weui-tabbar__item buy ajaxproxy" proxy='{"formId":"F_ListForms", "method":"post" ,"location":"<?php echo site_url('mobile/order/index').'#paypage'?>"}' data-loading-text="loading...">去结算</a>
	</div>
</div>
<?php echo template('mobile/script');?>
<script>
$(function(){
	$('.cart_check').on('change.radiocheck',function(e){
		var target = e.target;
		var ttl = parseFloat($('#price_total').html());
		var vttl = parseFloat($(this).data('total'));
		if ( target.checked == true ) {
			total(ttl + vttl);
		}else{
			total(ttl - vttl);
		}
	});
	//全选事件
	var form = document.getElementById('F_ListForms');
	if ( form != null ) {
	    var elements = form.elements;
	    var length = elements.length;
	    $('#check-all-cart').on('change.radiocheck', function(e) {
	    //获取事件对象
	    var target = e.target;
	    var t=0;
	    for ( var i = 0; i < length; i++ ) {
	        if ( elements[i].type != 'checkbox' || (elements[i].name != 'ids[]') ) continue;
		        if ( target.checked == true ) {
		        	$(elements[i]).prop('checked',true);
		        	t += parseFloat($(elements[i]).data('total'));
		        	total(t);
		        } else {
		        	$(elements[i]).prop('checked',false);
		        	total(0);
	            }
	        }
	    });
	}
	
	function total(val){
		$('#price_total').html(val.toFixed(2));
	}
	//sku的隐藏和显示
	var $iosActionsheet = $('#iosActionsheet');//sku层
	var $iosMask = $('#iosMask');//遮罩层
	$iosMask.on('click', hideActionSheet);
	$('#iosActionsheetCancel').on('click', hideActionSheet);
	function hideActionSheet() {
		$iosActionsheet.removeClass('weui-actionsheet_toggle');
		$iosMask.fadeOut(200);
	}
	$(".showIOSActionSheet").on("click", function(){
		var num = $(this).data('num');
		$('#cid').val($(this).data('cid'));
		$('#xz_num').val(num);
		$iosActionsheet.addClass('weui-actionsheet_toggle');
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
	<div class="weui-actionsheet__menu" >
		<div class="weui-actionsheet__cell header" >
			<div class="weui-flex">
	            <div class="weui-flex__item"><h4>编辑</h4></div>
	            <div class="weui-flex__item" style="flex:1 1 5%;">
		            <span id="iosActionsheetCancel" class='pull-right' style="margin:-5px -5px 0 0">
						<svg class="icon" style="font-size: 30px;" aria-hidden="true"><use xlink:href="#icon-guanbi"></use></svg>
					</span>
	            </div>
	        </div>
		</div> 
		
	    <div class="weui-actionsheet__cell">
	    <form id="edit_cart">
			<div class="weui_cell">
				<div class="weui_cell_bd weui_cell_primary text-left">购买数量</div>
				<div style="font-size: 0px;" class="weui_cell_ft">
						<a class="weui-number weui-number-sub needsclick">-</a>
						<input pattern="[0-9]*" class="weui-number-input" name="data[num]" style="width: 50px;" id='xz_num' readonly value="1" data-min="1" data-max="1000" data-step="1">
						<a class="weui-number weui-number-plus needsclick">+</a> 
				</div> 
			</div>
			<input type="hidden" id="cid" name="data[cid]">
	    </form>
	    </div>
	    
		<div class="weui-actionsheet__cell footers ajaxproxy" href="<?php echo site_url('mobile/cart/edit_cart')?>" 
		proxy='{"formId":"edit_cart", "method":"post" ,"location":"reload"}' 		data-loading-text="loading...">
		确 认 修 改
		</div>
	</div>
</div>
<?php }else{?>
<div style="background-color: #fff;position: absolute;top:0;bottom: 0;left: 0;right: 0;">
	<div class="weui-msg" >
	        <div class="weui-msg__icon-area"><i class="weui-icon-waiting weui-icon_msg"></i></div>
	        <div class="weui-msg__text-area">
	            <h3 class="weui-msg__title">购物车竟然是空的</h3>
	            <p class="weui-msg__desc">再忙，也要记得买点什么犒赏自己~</p>
	        </div>
	        <div class="weui-msg__opr-area">
	            <p class="weui-btn-area">
	                <a href="<?php echo site_url('mobile/mall/index')?>" class="weui-btn weui-btn_primary">赶紧去逛逛</a>
	            </p>
	        </div>
	        <div class="weui-msg__extra-area">
	            <div class="weui-footer">
	                <p class="weui-footer__links">
	                    <a href="<?php echo site_url('mobile/center/index')?>" class="weui-footer__link">会员中心</a>
	                </p>
	        	</div>
			</div>
	</div>
</div><!-- end container -->
<?php }?>
<script src="<?php echo JS_PATH.'mobile/font/iconfont.js'?>"></script>
</body>
</html>