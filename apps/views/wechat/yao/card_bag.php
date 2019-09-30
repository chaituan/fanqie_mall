<?php template('wechat/top')?>
<?php if(!$user['card_num']){ ?>
<div id="main">
	<div class="main-top" style="width: 75%; margin-bottom: 5%">
		<img src="<?php echo IMG_PATH;?>lbxb/xunbaotask_title.png" alt="">
	</div>
	<div class="main-center" style="width: 80%">
		<img src="<?php echo IMG_PATH;?>lbxb/notaketask.png" alt="">
	</div>
	<div class="abs get-btn">
		<a href="<?php echo site_url('wechat/yao/index')?>"><img src="<?php echo IMG_PATH;?>lbxb/get.png" alt=""></a>
	</div>
</div>
<?php
} else {
	$st = count ( explode ( ',', $user ['card_state'] ) );
	if ($st == 3) { // 全部核销		?>
<div id="main">
	<div class="main-top" style="width: 75%; margin-bottom: 5%">
		<img src="<?php echo IMG_PATH;?>lbxb/xunbaotask_title.png" alt="">
	</div>
	<div class="main-center" style="width: 80%">
		<img src="<?php echo IMG_PATH;?>lbxb/oktaketask.png" alt="">
	</div>
</div>
<?php
	} else {
		$code = explode ( ',', $user ['card_code'] );
		foreach ( $code as $v ) {
			$c = explode ( '|', $v );
			$vs .= "{cardId:'{$c[0]}',code:'{$c[1]}'},";
		}
		$cods = substr ( $vs, 0, - 1 );
		?>
<div id="main">
	<div class="main-center" style="width: 40%; margin-top: 60%;">
		<img src="<?php echo IMG_PATH;?>lbxb/mytask_btn.png" alt="">
	</div>
</div>
<script src="<?php echo JS_PATH.'jquery.min.js'?>"></script>
<script>
$(function(){
	$('.main-center').click(function(){
			var cardList = [<?php echo $cods;?>];
			wx.openCard({
			    cardList: cardList,
			    cancel: function (res) {
			        alert(JSON.stringify(res))
			   }
			});

		});
});
</script>
<?php echo template('wechat/share');?>
<?php }} ?>
<?php echo template('wechat/footer');?>
