<?php template('wechat/top')?>
<div id="main">
	<div class="avatar-pane">
		<img src="<?php echo $U['thumb'];?>" alt="" style="border-radius: 50%;">
	</div>
	<div class="username-pane tCenter">
		<span class="username tCenter"><?php echo $U['nickname'];?></span>
	</div>
	<div class="main-center" style="">
		<img src="<?php echo IMG_PATH;?>lbxb/xunbaomap_center.png" alt="">
		<div class="task-num"><?php echo 3 - ($U['card_state']?count(explode(",",$U['card_state'])):0);?></div>
		<div class="abs what-btn">
			<img src="<?php echo IMG_PATH;?>lbxb/what_btn.png" alt="">
		</div>
		<?php $c_num = explode(",",$U['card_num']); foreach ($map as $key=>$v){?>
			<div id="logo<?php echo $key;?>" class="abs logo <?php if(in_array($v[1], $c_num)){echo "logo_ok";}else{echo "logo_no";} ?> " data-id=<?php echo $key;?> data-cardid=<?php echo $v[1];?>>
			<img src="<?php echo IMG_PATH."lbxb/".$v[0];?>" alt="">
		</div>
		<?php }?>
	</div>
	<div class="main-bottom">
		<div class="col-xs-5 player-btn">
			<a href="#"><img src="<?php echo IMG_PATH;?>lbxb/player.png" alt=""></a>
		</div>
		<div class="col-xs-5 col-xs-offset-2 open-btn">
			<img src="<?php echo IMG_PATH;?>lbxb/open.png" alt="">
		</div>
	</div>
</div>
<script src="<?php echo JS_PATH.'jquery.min.js'?>"></script>
<script src="<?php echo JS_PATH.'bootstrap.min.js'?>"></script>
<script src="<?php echo JS_PATH.'AjaxProxy.js'?>"></script>
<script src="<?php echo JS_PATH.'layer/layer.js'?>"></script>
<script src="<?php echo JS_PATH.'JForm.js'?>"></script>
<script src="<?php echo JS_PATH.'common.js'?>"></script>
<script>
	$(function(){
		$('.what-btn').click(function(){
		$('#myModal1').modal();
		$('#mask1').width($(window).outerWidth()).height($(window).outerHeight()).show();
	});

		//已领取
	$('.logo_ok').each(function(i){
		$(this).click(function(){
			$('#myModal3').modal();
		});
	});
	
		//邀请
  	$('.inviteeat-btn').click(function(){
		$('#myModal4').modal();
	});

	  //没有领取
	$('.logo_no').each(function(i){
		$(this).click(function(){
			//弹出领取框
			
			var cardid = $(this).data('cardid');
	  		var id = $(this).data('id');
	  		
	  		$('.mytask-btn').attr("data-cardid",cardid);
	  		$('.mytask-btn').attr("data-id",id);
			$('#myModal2 .modal-logo>img').attr('src');
			$('#myModal2').modal();
		});
	});
	
		//领取卡券
		$('.mytask-btn').click(function(){
			$('#waiting').show();
			var cardid = $(this).attr('data-cardid');
	  		var id = $(this).attr('data-id');
  			$.ajax({
	  			type:'post',
	  			url:"<?php echo site_url('wechat/share/card');?>",
	  			data:{cardid:cardid},
	  			dataType:'json',
	  			success:function(data){
	  				$('#waiting').hide();
	  				if(data.state == 1){
	  					wx.addCard({
							   cardList: [{
							        cardId: data.message,
							        cardExt: data.data
							    }], 
							    success: function (res) {
								    //领取成功
								    $.ajax({
								    	url:"<?php echo site_url("wechat/share/card_success")?>",
										type:"post",
										dataType:'json',
										success:function(d){
												if(d.state==1){
													$('#myModal3').modal();
												}else{
													layer.msg(d.message,{icon:d.state});
												}
										}
									});
							    }
						});
	  				}else{
	  					layer.msg(data.message,{icon:data.state});
	  				}
	  			},
	  			error:function(){
	  				alert('网络错误')
	  			}
  			})
		});
	  
	  $('.open-btn').click(function(){
	  		$.ajax({
	  			type:'post',
	  			url:"<?php echo site_url("wechat/share/card_state")?>",
	  			dataType:'json',
	  			success:function(data){
	  				if(data.state == 1){
	  					$('#myModal5').modal();
	  				}else if (data.state == 3){
	  					$('#myModal6').modal();
			  		}else{
	  					$('#myModal7').modal();
		  			}
	  			},
	  			error:function(){
	  				alert('网络错误')
	  			}
	  		})
  		});
	 $('.eater-btn').click(function(){
		 $('#myModal7').modal('hide');
	 });
	
});
</script>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog">
	<div class="modal-dialog" style="width: 82%; margin-top: 20%;">
		<img src="<?php echo IMG_PATH;?>lbxb/rule.png" alt="">
		<div id="mask1" class="mask" data-dismiss="modal"></div>
	</div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog">
	<div class="modal-dialog" style="width: 88%; margin-top: 10%">
		<img src="<?php echo IMG_PATH;?>lbxb/tasktip_bg.png" alt="">
		<div class="abs close" data-dismiss="modal">
			<img src="<?php echo IMG_PATH;?>lbxb/close.png">
		</div>
		<div class="abs modal-logo">
			<img src="<?php echo IMG_PATH;?>lbxb/logo.png" alt="">
		</div>
		<div class="abs modal-headline">
			<img src="<?php echo IMG_PATH;?>lbxb/zhupabao_btn.png" alt=""> <span class="abs" id="task-title">吃掉一个美味的猪扒包</span>
		</div>
		<div class="abs coupon-pane">
			<img src="<?php echo IMG_PATH;?>lbxb/coupon_pane.png" alt="">
		</div>
		<div class="abs mytask-btn" data-dismiss="modal">
			<img src="<?php echo IMG_PATH;?>lbxb/mytask_btn.png" alt="">
		</div>
		<div class="abs inviteeat-btn" data-dismiss="modal">
			<img src="<?php echo IMG_PATH;?>lbxb/inviteeat_btn.png" alt="">
		</div>
		<div class="abs xunbao-entry">
			<img src="<?php echo IMG_PATH;?>lbxb/xunbao_pane.png" alt="">
			<!-- 	<a href="#" class="abs xunbao" id="xunbao-map"></a>
  		<a href="#" class="abs xunbao" id="xunbao-taskcard"></a> -->

		</div>
	</div>
</div>

<div class="modal fade" id="myModal3" tabindex="-1" role="dialog">
	<div class="modal-dialog" style="width: 82%; margin-top: 15%">
		<img src="<?php echo IMG_PATH;?>lbxb/taken_bg.png" alt="">
		<div class="abs taken-title">
			<img src="<?php echo IMG_PATH;?>lbxb/taken_title.jpg" alt="">
		</div>
		<div class="abs xunbao-entry">
			<img src="<?php echo IMG_PATH;?>lbxb/xunbao_pane.png" alt="">
		</div>
	</div>
</div>

<div class="modal fade" id="myModal4" tabindex="-1" role="dialog">
	<div class="modal-dialog" style="width: 50%; margin-left: 47%; margin-top: 3%">
		<img src="<?php echo IMG_PATH;?>lbxb/share_guide.png" alt="">
	</div>
</div>

<div class="modal fade" id="myModal5" tabindex="-1" role="dialog">
	<div class="modal-dialog" style="width: 82%; margin-top: 15%">
		<img src="<?php echo IMG_PATH;?>lbxb/sign_bg.png" alt="">
		<form id="submit-form" class="abs submit-form" style="margin-left: 8%">
			<div class="row">
				<label class="col-xs-4" for="username">姓名：</label> <input class="col-xs-8 input-box" type="text" id="username" name="data[username]" cname='姓名' required>
			</div>
			<div class="row">
				<label class="col-xs-4" for="mobile">电话：</label> <input class="col-xs-8 input-box" type="text" id="mobile" cname='电话' name="data[mobile]" dtype="mobile" required>
			</div>
			<div class="row">
				<label class="col-xs-4" for="wechat-num">微信号：</label> <input class="col-xs-8 input-box" type="text" id="wechat-num" cname='微信号' name="data[wx_id]" required>
			</div>
			<div class="row" style="margin-top: 3%">
				<div class="col-xs-4 col-xs-offset-4">
					<a href="<?php echo site_url('wechat/yao/edit_user')?>" class="submit-btn ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"submit-form", "method":"post", "location":"#","callBack":"subclose()"}'> <img src="<?php echo IMG_PATH;?>lbxb/submit_btn.png" alt="">
					</a>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="modal fade" id="myModal6" tabindex="-1" role="dialog">
	<div class="modal-dialog" style="width: 82%; margin-top: 20%">
		<img src="<?php echo IMG_PATH;?>lbxb/submit_success.png" alt="">
		<div id="mask2" class="mask" data-dismiss="modal"></div>
	</div>
</div>
<div class="modal fade" id="myModal7" tabindex="-1" role="dialog">
	<div class="modal-dialog" style="width: 82%; margin-top: 20%">
		<img src="<?php echo IMG_PATH;?>lbxb/nothree_bg.png" alt="">
		<div class="abs eater-btn" data-dismiss="modal">
			<img src="<?php echo IMG_PATH;?>lbxb/eat_btn.png" alt="">
		</div>
	</div>
</div>
<script>
function subclose(){
	layer.msg("提交成功",{icon:1});
 	$('#myModal5').modal('hide');
}
</script>
<?php echo template('wechat/share');?>
<?php echo template('wechat/footer');?>
