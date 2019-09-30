<?php echo template('shop/header');echo template('shop/sider');?>

<div id="content" class="app-content" role="main">
	<div class="app-content-body">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-list-alt fa-fw"></i> 列表 (默认不列出，搜索即可显示)
				</div>
				<div class="row wrapper">
					<div class="col-sm-3">
						<form action="<?php echo $index_url;?>" method="get">
							<div class="input-group">
								<input type="text" name="name" class="form-control input-sm" value="<?php echo isset($name)?$name:"";?>" placeholder="请输入商品ID" /> <span class="input-group-btn">
									<button class="btn btn-sm btn-default" type="submit">Go!</button>
								</span>
							</div>
						</form>
					</div>
				</div>
				<form id="J_ListForm" editable-form role="form" name="editableForm" method="post">
					<div class="table-responsive">
						<table class="table table-striped b-t b-light" style="margin-bottom: 0;">
							<thead>
								<tr>
									<th>商品ID</th>
									<th>评价内容(鼠标放上去可以看到全部)</th>
									<th>时间</th>
								</tr>
							</thead>
							<tbody>
                                <?php if (empty($items)){ ?>
	                            <tr>
									<td class="empty-table-td"><?php echo $emptyRecord;?></td>
								</tr>
                                <?php }else{ foreach ($items as $v){ ?>
                                <tr>
									<td><?php echo $v['gid'];?></td>
									<td title="<?php echo $v['content'];?>"><?php echo str_cut($v['content'], 30);?></td>
									<td><?php echo format_time($v['addtime']);?></td>
								</tr>
                                <?php }}?>
                                </tbody>
						</table>
					</div>
				</form>
				<footer class="panel-footer">
					<div class="row">
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
<?php echo template('shop/script');?>
<?php echo template('shop/footer');?>