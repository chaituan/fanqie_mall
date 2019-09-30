<?php echo template('mobile/header');?>
<header>
<div class="fanqie_top_bar" >
		<div class="fanqie_top_pull_left" onclick="javascript:history.go(-1);">
		  	<svg class="icon" aria-hidden="true"><use xlink:href="#icon-fanhui"></use></svg>
		</div>
		<div class="fanqie_top_title">编辑个人资料</div>
</div>
<div class="hr_40"></div>
</header>
<div class="page ">
<form id="F_ListForms">
	<div class="weui-cells weui-cells_form">
			<div class="weui-cell" >
				<div class="weui-cell__hd">
					<label class="weui-label">昵称</label>
				</div>
				<div class="weui-cell__bd">
                    <input  type="text" class="weui-input" name="data[nickname]" value="<?php echo $U['nickname'];?>"  required >
                </div>
			</div>
			<div class="weui-cell" >
				<div class="weui-cell__hd">
					<label class="weui-label">手机号码</label>
				</div>
				<div class="weui-cell__bd">
                    <input type="text" class="weui-input" name="data[mobile]" dtype="mobile" cname="手机号码"  value="<?php echo $U['mobile'];?>" required>
                </div>
			</div>
    </div>
    <div class="weui-btn-area">
	    <a href="<?php echo site_url('mobile/center/edit_user')?>" class="weui-btn weui-btn_primary ajaxproxy" 
		proxy='{"formId":"F_ListForms", "method":"post" ,"location":"goback"}' >确认提交</a>
	</div>
</form>
</div>
<?php echo template('mobile/script');?>
<?php echo template('mobile/footer');?>