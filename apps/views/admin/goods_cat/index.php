<?php echo template('admin/header');echo template('admin/sider');?>

<div id="content" class="app-content" role="main">
	<div class="app-content-body">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="pull-right"><a href="<?php echo $add_url;?>"><i class="fa fa-plus fa-fw"></i> 添加</a></span> <i class="fa fa-list-alt fa-fw"></i> 列表
				</div>
				<form id="J_ListForm" editable-form role="form" name="editableForm" method="post">
					<div class="table-responsive">
						<table class="table table-striped b-t b-light" style="margin-bottom: 0;">
							<thead>
								<tr>
									<th width="70">排序</th>
									<th>名称</th>
									<th>广告链接</th>
									<th>首页推荐</th>
									<th>显示</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
                                <?php if (empty($items)){ ?>
	                            <tr>
									<td class="empty-table-td"><?php echo $emptyRecord;?></td>
								</tr>
                                <?php }else{ foreach ($items as $value){ ?>
                                <tr>
									<td><input type="text" name="data[<?php echo $value['id']?>]" class="form-control input-sm" style="padding: 0; height: 25px; text-align: center;" value="<?php echo $value['sort'];?>"></td>
									<td><?php echo $value['names'];?></td>
									<td><?php echo $value['thumbadvurl'];?></td>
									<td><?php echo $value['isrecommand']?'是':'否';?></td>
									<td><?php echo $value['enabled']?'是':'否';?></td>
									<td><a href="<?php echo site_url('adminct/goods_cat/edit/id-'.$value['id']); ?>" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-pencil"></i></a> <a href="<?php echo site_url('adminct/goods_cat/delete/id-'.$value['id']); ?>" class="btn btn-xs btn-danger delone"><i class="fa fa-fw fa-times"></i></a></td>
								</tr>
                                	<?php if(!isset($value['children']))continue;foreach ($value['children'] as $v){?>
                                	<tr>
									<td><input type="text" name="data[<?php echo $v['id']?>]" class="form-control input-sm" style="padding: 0; height: 25px; text-align: center;" value="<?php echo $v['sort'];?>"></td>
									<td><?php echo ' ├ '.$v['names'];?></td>
									<td><?php echo $v['thumbadvurl'];?></td>
									<td><?php echo $v['isrecommand']?'是':'否';?></td>
									<td><?php echo $v['enabled']?'是':'否';?></td>
									<td><a href="<?php echo site_url('adminct/goods_cat/edit/id-'.$v['id']); ?>" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-pencil"></i></a> <a href="<?php echo site_url('adminct/goods_cat/delete/id-'.$v['id']); ?>" class="btn btn-xs btn-danger delone"><i class="fa fa-fw fa-times"></i></a></td>
								</tr>
                                	<?php if(!isset($v['children']))continue;foreach ($v['children'] as $b){//第三级?>
                                	<tr>
									<td><input type="text" name="data[<?php echo $b['id']?>]" class="form-control input-sm" style="padding: 0; height: 25px; text-align: center;" value="<?php echo $b['sort'];?>"></td>
									<td><?php echo ' ├├ '.$b['names'];?></td>
									<td><?php echo $b['thumbadvurl'];?></td>
									<td><?php echo $b['isrecommand']?'是':'否';?></td>
									<td><?php echo $b['enabled']?'是':'否';?></td>
									<td><a href="<?php echo site_url('adminct/goods_cat/edit/id-'.$b['id']); ?>" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-pencil"></i></a> <a href="<?php echo site_url('adminct/goods_cat/delete/id-'.$b['id']); ?>" class="btn btn-xs btn-danger delone"><i class="fa fa-fw fa-times"></i></a></td>
								</tr>
                                <?php }}}}?>
                                </tbody>
						</table>
					</div>
				</form>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-5 hidden-xs">
							<a href="<?php echo site_url('adminct/goods_cat/order_by')?>" class="btn btn-sm btn-primary m-b-xs btn-addon ajaxproxy" data-loading-text="正在删除" proxy='{"formId":"J_ListForm", "method":"post","location":"reload","tips":"ok"}'> <i class="fa fa-list-ol"></i> 排 序
							</a>
						</div>
						<div class="col-sm-7 text-right text-center-xs">
							<ul class="pagination pagination-sm m-t-none m-b-none">
			                   <?php echo !empty($pagemenu)?$pagemenu:"";?>
			                </ul>
						</div>
					</div>
				</footer>
			</div>
		</div>
	</div>
</div>
<?php echo template('admin/script');?>
<?php echo template('admin/footer');?>