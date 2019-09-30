<?php  echo template('shop/header');echo template('shop/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading font-bold">
					<i class="fa fa-edit fa-fw"></i> 收益管理
				</div>
				<div class="panel-body">
					<form class="form-horizontal" autocomplete="off" id="content_add_form">
					<div class="form-group">
							<label class="col-sm-2 control-label">预计收益</label>
							<div class="col-sm-10">
								<p class="form-control-static"><?php echo $yuji;?> 元</p>
							</div>
					</div>
					<div class="line line-dashed b-b line-lg pull-in"></div>
					<div class="form-group">
							<label class="col-sm-2 control-label">可提现金额</label>
							<div class="col-sm-10">
								<p class="form-control-static"><?php echo $ok;?> 元</p>
							</div>
					</div>
					<div class="line line-dashed b-b line-lg pull-in"></div>
					<div class="form-group">
							<label class="col-sm-2 control-label">输入提现金额</label>
							<div class="col-sm-10">
								<input type="text" name="data[money]" dtype="number" cname='提现金额' max-length='7' class="form-control" required>
							</div>
					</div>
					<div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<a href="<?php echo site_url('shop/set/edit')?>" class="btn btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"content_add_form", "method":"post", "location":"reload"}'>保存修改</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo template('shop/script');?>
<script type="text/javascript">
function sub(){
	
}
</script>
<?php echo template('shop/footer');?>
