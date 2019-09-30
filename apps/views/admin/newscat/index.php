<?php echo template('admin/header');echo template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="pull-right"><a href="<?php echo $add_url;?>"><i class="fa fa-plus fa-fw"></i> 添加</a></span> <i class="fa fa-list-alt fa-fw"></i> 列表
				</div>
				<form id="J_ListForm" role="form" method="post">
					<div class="table-responsive">
						<table class="table table-striped b-t b-light" style="margin-bottom: 0;">
							<thead>
								<tr>
									<th>ID</th>
									<th>分类名称</th>
									<th>添加时间</th>
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
									<td><?php echo $value['id'];?></td>
									<td><?php echo $value['catname'];?></td>
									<td><?php echo format_time($value['addtime']);?></td>
									<td><a href="<?php echo site_url('adminct/newscat/edit/id-'.$value['id']); ?>" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-pencil"></i></a> <a href="<?php echo site_url('adminct/newscat/delete/id-'.$value['id']); ?>" class="btn btn-xs btn-danger delone"><i class="fa fa-fw fa-times"></i></a></td>
								</tr>
                                	<?php if(!isset($value['children']))continue;foreach ($value['children'] as $v){?>
                                	<tr>
									<td><?php echo $v['id'];?></td>
									<td><?php echo ' ├ '.$v['catname'];?></td>
									<td><?php echo format_time($v['addtime']);?></td>
									<td><a href="<?php echo site_url('adminct/newscat/edit/id-'.$v['id']); ?>" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-pencil"></i></a> <a href="<?php echo site_url('adminct/newscat/delete/id-'.$v['id']); ?>" class="btn btn-xs btn-danger delone"><i class="fa fa-fw fa-times"></i></a></td>
								</tr>
                                	<?php if(!isset($v['children']))continue;foreach ($v['children'] as $b){//第三级?>
                                	<tr>
									<td><?php echo $b['id'];?></td>
									<td><?php echo ' ├├ '.$b['catname'];?></td>
									<td><?php echo format_time($b['addtime']);?></td>
									<td><a href="<?php echo site_url('adminct/newscat/edit/id-'.$b['id']); ?>" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-pencil"></i></a> <a href="<?php echo site_url('adminct/newscat/delete/id-'.$b['id']); ?>" class="btn btn-xs btn-danger delone"><i class="fa fa-fw fa-times"></i></a></td>
								</tr>
                                <?php }}}}?>
                                </tbody>
						</table>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php echo template('admin/script');?>
<?php echo template('admin/footer');?>