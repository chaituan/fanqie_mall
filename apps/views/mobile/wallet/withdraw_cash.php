<?php echo template('mobile/header');?>
<header>
<div class="fanqie_top_bar" >
		<div class="fanqie_top_pull_left" onclick="javascript:history.go(-1);">
		  	<svg class="icon" aria-hidden="true"><use xlink:href="#icon-fanhui"></use></svg>
		</div>
		<div class="fanqie_top_title">收益提现</div>
</div>
<div class="hr_40"></div>
</header>
<div class="page">
<form id="F_ListForms">
	<div class="weui-cells weui-cells_form">
			<div class="weui-cell" >
				<div class="weui-cell__hd">
					<label class="weui-label">输入金额：</label>
				</div>
				<div class="weui-cell__bd">
                    <input  type="text" class="weui-input" name="money" cname="提现金额" dtype="number" range="0-<?php echo $ktx;?>" required>
                </div>
			</div>
    </div>
    <div class="weui-cells__tips">*提现后会进入系统审核状态，审核成功则到账</div>
    <div class="weui-btn-area">
	    <a href="" class="weui-btn weui-btn_primary ajaxproxy" proxy='{"formId":"F_ListForms","method":"post","location":"<?php echo site_url('mobile/wallet')?>"}' >确认提现</a>
	</div>
</form>	
</div>
<?php echo template('mobile/script');?>
<?php echo template('mobile/footer');?>