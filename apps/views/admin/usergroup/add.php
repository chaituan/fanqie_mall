<?php echo template('admin/header');echo template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading font-bold">
					<span class="pull-right"><a href="<?php echo $index_url;?>"><i class="fa fa-arrow-circle-left fa-fw"></i> 返回</a></span> <i class="fa fa-plus fa-fw"></i> 添加
				</div>
				<div class="panel-body">
					<form class="form-horizontal" autocomplete="off" id="content_add_form">
						<div class="form-group">
							<label class="col-sm-2 control-label">名称</label>
							<div class="col-sm-10">
								<input type="text" name="data[gname]" class="form-control" cname="名称"  required>
							</div>
						</div>
						<div class="line line-dashed b-b line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">粉丝数量</label>
							<div class="col-sm-10">
								<input type="text" name="data[fans_num]" class="form-control" cname="粉丝数量" value="1000" required>
							</div>
						</div>
						<div class="line line-dashed b-b line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">一级</label>
							<div class="col-sm-10">
								<div class="input-group">
									<input type="text" name="data[p_1]" class="form-control" cname="一级" value="0" required> <span class="input-group-addon">%</span>
								</div>
							</div>
						</div>
						<div class="line line-dashed b-b line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">二级</label>
							<div class="col-sm-10">
								<div class="input-group">
									<input type="text" name="data[p_2]" class="form-control" cname="二级" value="0" required>  <span class="input-group-addon">%</span>
								</div>
							</div>
						</div>
						<div class="line line-dashed b-b line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">说明</label>
							<div class="col-sm-10">
								<input type="text" name="data[summary]" class="form-control" placeholder="会员组简介" required>
							</div>
						</div>
						<div class="line line-dashed b-b line-lg pull-in"></div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<a href="<?php echo site_url($add_url)?>" class="btn btn-sm btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"content_add_form", "method":"post","tips":"ok" ,"location":"<?php echo site_url($index_url)?>"}'>保存修改</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo template('admin/script');?>
<?php echo template('admin/footer');?>