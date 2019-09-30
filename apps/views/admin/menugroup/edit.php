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
							<label class="col-sm-2 control-label">分组名称</label>
							<div class="col-sm-10">
								<input type="text" name="data[name]" class="form-control" placeholder="分组名称" value="<?php echo $item['name']?>" required>
								<p class="help-block">中英文皆可，长度不超过20</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">分组key</label>
							<div class="col-sm-10">
								<input type="text" name="data[tkey]" class="form-control" value="<?php echo $item['tkey'];?>" placeholder="分组key" required> <input type="hidden" name="tkey_bak" value="<?php echo $item['tkey']?>">
								<p class="help-block">请保持唯一，并且长度不超过20</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">分组图标</label>
							<div class="col-sm-10">
								<input type="text" name="data[icon]" class="form-control" value="<?php echo $item['icon']?>" placeholder="分组图标">
								<p class="help-block">长度不超过16</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">排序数字</label>
							<div class="col-sm-10">
								<input type="text" name="data[sort_num]" class="form-control" dtype="number" value="<?php echo $item['sort_num']?>" placeholder="排序数字" required>
								<p class="help-block">数字越小越靠前，三位数以内</p>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="hidden" name="id" value="<?php echo $item['id'];?>" /> <a href="<?php echo site_url('adminct/menugroup/edit')?>" class="btn btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"content_add_form", "method":"post", "location":"<?php echo site_url('adminct/menugroup/index')?>"}'>保存修改</a>
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