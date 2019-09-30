<?php echo template('admin/header');echo template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading font-bold">
					<span class="pull-right"> <a href="<?php echo $add_url;?>"><i class="fa fa-plus fa-fw"></i> 添加</a>&nbsp;&nbsp;&nbsp; <a href="<?php echo $index_url;?>"><i class="fa fa-arrow-circle-left fa-fw"></i> 返回</a>
					</span> <i class="fa fa-edit fa-fw"></i> 编辑
				</div>
				<div class="panel-body">
					<form class="form-horizontal" autocomplete="off" id="content_add_form">
						<div class="form-group">
							<label class="col-sm-2 control-label">密码</label>
							<div class="col-sm-10">
								<input type="text" name="data[pwd]" class="form-control" cname="密码" placeholder="留空不修改">
							</div>
						</div>
						<div class="line line-dashed b-b line-lg pull-in"></div>
						<div class="form-group">
							<input type="hidden" name="id" value="<?php echo $item['id']?>">
							<div class="col-sm-offset-2 col-sm-10">
								<a href="<?php echo site_url($edit_url)?>" class="btn btn-sm btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"content_add_form", "method":"post", "location":"<?php echo site_url($index_url)?>"}'>保存修改</a>
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