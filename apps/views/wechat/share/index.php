<?php template('wechat/top')?>
<div id="main">
	<div class="main-top" style="width: 70%; margin-bottom: 3%">
		<img src="<?php echo IMG_PATH;?>lbxb/xunbaomap_title.png" alt="">
	</div>
	<div class="main-center" style="width: 80%">
		<img src="<?php echo IMG_PATH;?>lbxb/howtojoin_gift.png" alt="">
	</div>
	<div class="abs get-btn" style="bottom: -20%">
		<img src="<?php echo IMG_PATH;?>lbxb/howtojoin_btn.png" alt="">
	</div>
</div>
<script src="<?php echo JS_PATH.'jquery.min.js'?>"></script>
<script src="<?php echo JS_PATH.'bootstrap.min.js'?>"></script>
<script>
$(function(){
	$('.get-btn').click(function(){
		  $('#myModal').modal();
  	})
});
</script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" style="width: 85%; margin-top: 20%;">
		<img src="<?php echo IMG_PATH;?>lbxb/yao_bg.png" alt="">
		<div class="abs getmap-btn">
			<img src="<?php echo IMG_PATH;?>lbxb/get_map.png" alt="">
		</div>
	</div>
</div>
<?php echo template('wechat/footer');?>