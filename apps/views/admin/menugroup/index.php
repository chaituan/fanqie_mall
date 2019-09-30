<?php echo template('admin/header');echo template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body animated fadeInRight">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="pull-right"><a href="<?php echo $add_url;?>"><i class="fa fa-plus fa-fw"></i> 添加</a></span> <i class="fa fa-list-alt fa-fw"></i> 列表
				</div>
				<!-- content form start -->
				<form id="J_ListForm" name="contentListForm">
					<div class="table-responsive">
						<table class="table table-striped b-t b-light" style="margin-bottom: 0;">
							<thead>
								<tr>
									<th>ID</th>
									<th>分组名称</th>
									<th>分组key</th>
									<th>图标icon</th>
									<th>排序数字</th>
									<th>添加时间</th>
									<th>操作</th>
								</tr>
							</thead>

							<tbody>
	                            <?php if (empty($items)){?>
	                            <tr>
									<td class="empty-table-td"><?php echo $emptyRecord;?></td>
								</tr>
	                            <?php }?>
	
								<?php foreach ($items as $value){ ?>
	                            <tr>
									<td>
	                                   <?php echo $value['id']; ?>
	                                    <input type="hidden" name="hids[<?php echo $value['id']; ?>]" value="<?php echo $value['id']; ?>" />
									</td>
									<td><input type="text" name="data[<?php echo $value['id']; ?>][name]" value="<?php echo $value['name']; ?>" class="form-control input-sm" /></td>

									<td><input type="text" name="data[<?php echo $value['id']; ?>][tkey]" value="<?php echo $value['tkey']; ?>" class="form-control input-sm" /></td>
									<td><input type="text" name="data[<?php echo $value['id']; ?>][icon]" value="<?php echo $value['icon']; ?>" class="form-control input-sm" /></td>
									<td><input type="text" name="data[<?php echo $value['id']; ?>][sort_num]" value="<?php echo $value['sort_num']; ?>" class="form-control input-sm" /></td>
									<td><?php echo date('Y-m-d',$value['add_time']); ?></td>
									<td><a href="<?php echo site_url('adminct/menugroup/edit/id-'.$value['id'])?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a> <a href="<?php echo site_url('adminct/menugroup/delete/id-'.$value['id'])?>" class="btn btn-xs btn-danger delone"> <i class="fa fa-times"></i></a></td>
								</tr>
	                            <?php }?>
	                            </tbody>
						</table>
					</div>
					<footer class="panel-footer">
						<div class="row">
							<div class="col-sm-5 hidden-xs">
								<a href="<?php echo site_url('adminct/menugroup/quicksave');?>" class="ajaxproxy btn btn-sm btn-primary m-b-xs btn-addon" data-loading-text="正在保存……" proxy='{"method":"post", "formId":"J_ListForm", "location":"reload"}'> <i class="fa fa-save"></i> 快速保存
								</a>
							</div>
						</div>
					</footer>
				</form>
				<!-- form END -->
			</div>
		</div>
	</div>
</div>
<?php echo template('admin/script');?>
<?php echo template('admin/footer');?>