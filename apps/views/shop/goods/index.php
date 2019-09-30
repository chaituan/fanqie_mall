<?php echo template('shop/header');echo template('shop/sider');?>

<div id="content" class="app-content" role="main">
	<div class="app-content-body">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="pull-right"><a href="<?php echo $add_url;?>" class="label bg-success" style="color: #fff;">
					<i class="fa fa-plus fa-fw"></i> 添 加 </a></span> 
					<i class="fa fa-list-alt fa-fw"></i> 列表
				</div>
				<div class="row wrapper">
					<div class="col-sm-3">
						<form action="" method="get">
							<div class="input-group">
								<input type="text" name="name" class="form-control input-sm" value="<?php echo isset($name)?$name:"";?>" placeholder="请输入名称" /> <span class="input-group-btn">
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
									<th width="70">排序</th>
									<th>ID</th>
									<th>名称</th>
									<th>价格</th>
									<th>库存</th>
									<th>属性</th>
									<th>上架</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
                                <?php if (empty($items)){ ?>
	                            <tr>
									<td class="empty-table-td"><?php echo $emptyRecord;?></td>
								</tr>
                                <?php }else{ foreach ($items as $v){ ?>
                                <tr>
									<td><input type="text" name="data[<?php echo $v['id']?>]" class="form-control input-sm" style="padding: 0; height: 23px; text-align: center;" value="<?php echo $v['sort'];?>"></td>
									<td><?php echo $v['id']; ?></td>
									<td><?php echo $v['names'];?></td>
									<td><?php echo $v['price'];?></td>
									<td><?php echo $v['stock'];?></td>
									<td>
									<?php 
										if($v['is_recommand'])echo "<span class='btn btn-xs btn-info'>首页</span> ";
										if($v['is_new'])echo "<span class='btn btn-xs btn-success'>新品</span> ";
										if($v['is_first'])echo "<span class='btn btn-xs btn-warning'>首发</span> ";
										if($v['is_hot'])echo "<span class='btn btn-xs btn-danger'>热卖</span> ";
										if($v['is_jingping'])echo "<span class='btn btn-xs btn-primary'>精品</span>";
									?>
									
									</td>
									<td><?php echo $v['putaway']?'是':'否';?></td>
									<td>
										<a title="编辑" href="<?php echo site_url('adminct/goods/edit/id-'.$v['id']); ?>" class="btn btn-xs btn-primary">
											<i class="fa fa-fw fa-pencil"></i>
										</a> 
										<a title="删除" href="<?php echo site_url('adminct/goods/delete/id-'.$v['id']); ?>" class="btn btn-xs btn-danger delone">
											<i class="fa fa-fw fa-trash-o"></i>
										</a>
									</td>
								</tr>
                                <?php }}?>
                                </tbody>
						</table>
					</div>
				</form>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-5 hidden-xs">
							<a href="<?php echo site_url('adminct/goods/order_by')?>" class="btn btn-sm btn-primary m-b-xs btn-addon ajaxproxy" data-loading-text="正在删除" proxy='{"formId":"J_ListForm", "method":"post","location":"reload","tips":"ok"}'> <i class="fa fa-list-ol"></i> 排 序
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
<?php echo template('shop/script');?>
<?php echo template('shop/footer');?>