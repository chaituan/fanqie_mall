<?php echo template('admin/header');echo template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading font-bold">
					<span class="pull-right"> <a href="<?php echo $index_url;?>"><i class="fa fa-arrow-circle-left fa-fw"></i> 返回</a>
					</span> <i class="fa fa-edit fa-fw"></i> 编辑
				</div>
				<div class="panel-body">
					<form class="form-horizontal" autocomplete="off" id="content_add_form">
						<div class="form-group">
							<label class="col-sm-2 control-label">变量</label>
							<div class="col-sm-10">
								<input type="text" name="data[cname]" value="<?php echo $item['cname'];?>" class="form-control" placeholder="变量名" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">变量值</label>
							<div class="col-sm-10">
								<textarea name="data[val]" class="form-control" required><?php echo $item['val'];?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">说明</label>
							<div class="col-sm-10">
								<input type="text" name="data[bak]" value="<?php echo $item['bak'];?>" class="form-control" placeholder="说明" required>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="hidden" name="id" value="<?php echo $item['id'];?>"> <a href="<?php echo site_url('adminct/config/edit')?>" class="btn btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"content_add_form", "method":"post", "location":"<?php echo site_url('adminct/config/index')?>"}'>保存修改</a>
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
