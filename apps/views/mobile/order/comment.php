<?php echo template('mobile/header');?>
<header>
<div class="fanqie_top_bar" >
		<div class="fanqie_top_pull_left" onclick="javascript:history.go(-1);">
		  	<svg class="icon" aria-hidden="true"><use xlink:href="#icon-fanhui"></use></svg>
		</div>
		<div class="fanqie_top_title">订单评价</div>
</div>
<div class="hr_40"></div>
</header>
<div class="page ">
<form id="F_ListForms">
	<div class="weui-cells weui-cells_form">
	<?php foreach ($items as $k=>$v){?>
			<div class="weui-cell" >
				<div class="weui-cell__hd">
					<img src="<?php echo $v['thumb'];?>"  style="width: 50px;height: 50px; margin-right: 10px;">
				</div>
				<div class="weui-cell__bd">
                    <?php echo $v['title'];?>
                </div>
			</div>
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <textarea class="weui-textarea" cname="评价" rows="3" max-length='50' name="data[<?php echo $k;?>][content]" required>好评</textarea>
                </div>
            </div>
            <input type="hidden" name="data[<?php echo $k;?>][gid]" value="<?php echo $v['gid']?>">
            <input type="hidden" name="data[<?php echo $k;?>][oid]" value="<?php echo $v['id']?>">
            <input type="hidden" name="id" value="<?php echo $v['oid']?>">
     <?php }?>
    </div>
    <div class="weui-btn-area">
	    <a href="<?php echo site_url('mobile/order/comment')?>" class="weui-btn weui-btn_primary ajaxproxy" 
		proxy='{"formId":"F_ListForms", "method":"post" ,"location":"<?php echo site_url('mobile/order/lists')?>"}' data-loading-text="loading...">确认提交</a>
	</div>
</form>
</div>
<?php echo template('mobile/script');?>
<?php echo template('mobile/footer');?>