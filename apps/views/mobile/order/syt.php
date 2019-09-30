<?php echo template('mobile/header');?>
<div class="fanqie_top_bar" >
	<div class="fanqie_top_pull_left" onclick="back()">
	  	<svg class="icon" aria-hidden="true"><use xlink:href="#icon-fanhui"></use></svg>
	</div>
	<div class="fanqie_top_title">收银台</div>
</div>
<div class="hr_40"></div>
<div class="weui-cells center-list syt">
		<div class="weui-cell" href="javascript:;">
			<div class="weui-cell__bd ">订单金额</div>
			<div class="weui-cell__ft price">￥<?php echo $total;?> 元</div>
		</div> 
		<a class="weui-cell weui-cell_access wechat_pay" href="javascript:;">
			<div class="weui-cell__hd">
				<svg class="icon" aria-hidden="true"><use xlink:href="#icon-icon-wepay"></use></svg>
			</div>
			<div class="weui-cell__bd"><p>微信支付</p><p class="explain">微信安全支付</p></div>
			<div class="weui-cell__ft"></div>
		</a> 
		<a class="weui-cell weui-cell_access" href="javascript:;">
			<div class="weui-cell__hd">
				<svg class="icon" aria-hidden="true"><use xlink:href="#icon-zhanchangdaifu-"></use></svg>
			</div>
			<div class="weui-cell__bd"><p>微信好友代付</p><p class="explain">暂无开通</p></div>
			<div class="weui-cell__ft"></div>
		</a>
		<a class="weui-cell weui-cell_access" href="javascript:;">
			<div class="weui-cell__hd">
				<svg class="icon" aria-hidden="true"><use xlink:href="#icon-zhanchangdaifu-"></use></svg>
			</div>
			<div class="weui-cell__bd"><p>余额支付</p><p class="explain">暂无开通</p></div>
			<div class="weui-cell__ft"></div>
		</a>
</div>
<?php echo template('mobile/script');?>
<script type="text/javascript">
function back(){
	location.href = "<?php echo site_url('mobile/order/lists')?>";
}

$('.wechat_pay').click(function(){
	callpay();
});

function jsApiCall(){
	WeixinJSBridge.invoke(
		'getBrandWCPayRequest',
		<?php echo $pay_api; ?>,
		function(res){
			switch (res.err_msg){
	            case 'get_brand_wcpay_request:cancel':
	              	layer_msg("支付失败");
	               	location.href = "/mobile/order/lists/id-1.html";
	             	break;
	            case 'get_brand_wcpay_request:fail':
	            	layer_confirm("支付异常,截图联系客服"+res.err_code+res.err_desc+res.err_msg);
	                break;
	            case 'get_brand_wcpay_request:ok':
	            	layer_msg("支付成功");
	               	location.href = "/mobile/order/lists/id-2.html";
	                break;
			}
		}
	);
}

function callpay(){
	if (typeof WeixinJSBridge == "undefined"){
	    if( document.addEventListener ){
	        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
	    }else if (document.attachEvent){
	        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
	        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
	    }
	}else{
	    jsApiCall();
	}
}

</script>
<script src="<?php echo JS_PATH.'mobile/font/iconfont.js'?>"></script>
</div><!-- end container -->
</body>
</html>