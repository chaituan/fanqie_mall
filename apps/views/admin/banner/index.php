<?php echo template('admin/header');echo template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="pull-right"><a href="<?php echo $add_url;?>"><i class="fa fa-plus fa-fw"></i> 添加</a></span> <i class="fa fa-list-alt fa-fw"></i> 列表
				</div>
				<div class="table-responsive">
					<table class="table table-striped b-t b-light">
						<thead>
							<tr>
								<th>标题</th>
								<th>图片</th>
								<th>添加时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
                                <?php if (empty($items)){ ?>
	                            <tr>
								<td class="empty-table-td"><?php echo $emptyRecord;?></td>
							</tr>
	                            <?php }else{?>
                                <?php foreach ($items as $v){ ?>
                                <tr>
								<td><?php echo $v['title'];?></td>
								<td><img alt="" src="<?php echo $v['thumb'];?>" style="height: 25px;"></td>
								<td><?php echo format_time($v['addtime']);?></td>
								<td><a href="<?php echo site_url('adminct/banner/edit/id-'.$v['id']); ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a> <a href="<?php echo site_url('adminct/banner/delete/id-'.$v['id']); ?>" class="btn btn-xs btn-danger delone"><i class="fa fa-times"></i></a></td>
							</tr>
                                <?php }}?>
                                </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo template('admin/script');?>
<?php echo template('admin/footer');?>