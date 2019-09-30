<script src="<?php echo JS_PATH.'jweixin-1.0.0.js'?>"></script>
<script type="text/javascript">
$(function(){
	$('#waiting').show();
	$.ajax({
		url:"<?php echo site_url('wechat/share/index');?>",
		type:"post",
		data:{url:window.location.href},
		dataType:'json',
		async:true,
		success:function(data){
			if(data.state==1){
				$('#waiting').hide();
				var d = $.parseJSON(data.data);
				wx.config({
				   	debug: false,
				    appId: d.appId,
				    timestamp: d.timestamp,
				    nonceStr: d.nonceStr,
				    signature: d.signature,
				    jsApiList: [
				      'onMenuShareTimeline',
				      'onMenuShareAppMessage',
				      'addCard',
				      'openCard'
				    ]
				});
				/* wx.error(function(res){
					alert(res);
				}); */
			   wx.ready(function () {
			       wx.onMenuShareTimeline({
			    	    title: '寮步美食美食寻宝', // 分享标题
			    	    link: "<?php echo base_url("wechat/share/url/?uid={$U['id']}&");?>", // 分享链接
			    	    imgUrl: "<?php echo base_url('res/images/share/share.jpg');?>", // 分享图标
			    	    success: function () { 
			    	    	
			    	    },
			    	    cancel: function () { 
			    	        // 用户取消分享后执行的回调函数
			    	    }
			    	});
			       wx.onMenuShareAppMessage({
			    	    title: '寮步美食美食寻宝', // 分享标题
			    	    desc: 'DEMO测试页面', // 分享描述
			    	    link: "<?php echo base_url("wechat/share/url/?uid={$U['id']}&");?>", // 分享链接
			    	    imgUrl: 'http://yao.weicul.com/res/app/imgs/share.jpg', // 分享图标
			    	    type: '', // 分享类型,music、video或link，不填默认为link
			    	    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			    	    success: function () {
			    	    	
			    	    },
			    	    cancel: function () { 
			    	        // 用户取消分享后执行的回调函数
			    	    }
			    	});
			  });
			}else{
				alert(data.message);
			}
		},error:function(){
			alert("网络异常,请刷新");
		}
	});
	
	
});
</script>