<?php echo template('admin/header');template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<div class="alert alert-warning alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert">
				<span aria-hidden="true">×</span><span class="sr-only">Close</span>
			</button>
			<strong>注：本系统只支持二级分类，添加多级不会显示，如需多级请联系客服开发</strong>
		</div>
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading font-bold">
					<span class="pull-right"><a href="<?php echo $index_url;?>"><i class="fa fa-arrow-circle-left fa-fw"></i> 返回</a></span> <i class="fa fa-plus fa-fw"></i> 添加
				</div>
				<div class="panel-body">
					<form class="form-horizontal" autocomplete="off" id="content_add_form">
						<div class="form-group">
							<label class="col-sm-2 control-label"> 上级</label>
							<div class="col-sm-10">
								<select name="data[parent_id]" data-toggle="select" class="form-control select select-default" required>
									<option value="0">顶级</option>
                                	<?php foreach($parent as $v){?>
                                	<option value="<?php echo $v['id'];?>"> <?php echo str_repeat('├',$v['level']).' '.$v['catname'];?></option>
                                	<?php }?>
                            </select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"> 分类名称</label>
							<div class="col-sm-10">
								<input type="text" name="data[catname]" class="form-control" placeholder="文章分类名称" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"> 分类别名</label>
							<div class="col-sm-10">
								<input type="text" name="data[alias]" class="form-control" placeholder="分类别名" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"> 分类关键字</label>
							<div class="col-sm-10">
								<input type="text" name="data[keywords]" class="form-control" placeholder="分类关键字,可留空">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"> 分类描述</label>
							<div class="col-sm-10">
								<input type="text" name="data[description]" class="form-control" placeholder="分类描述,可留空">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<a href="<?php echo site_url($add_url)?>" class="btn btn-sm btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"content_add_form", "method":"post" ,"location":"<?php echo site_url($index_url)?>"}'>保存修改</a>
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