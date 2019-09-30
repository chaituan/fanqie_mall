<?php echo template('admin/header');echo template('admin/sider');?>

<div id="content" class="app-content" role="main">
	<div class="app-content-body">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-list-alt fa-fw"></i> 列表
				</div>
				<div class="row wrapper">
					<div class="col-sm-3">
						<form action="" method="get">
							<div class="input-group">
								<input type="text" name="name" class="form-control input-sm" value="<?php echo isset($name)?$name:"";?>" placeholder="请输入订单号" /> <span class="input-group-btn">
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
									<th>订单号</th>
									<th>收货人</th>
									<th>手机号</th>
									<th>总价</th>
									<th>下单时间</th>
									<th>状态</th>
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
									<td><?php echo $v['order_no'];?></td>
									<td><?php echo $v['buy_name'];?></td>
									<td><?php echo $v['buy_mobile'];?></td>
									<td><?php echo $v['price'];?></td>
									<td><?php echo format_time($v['addtime']);?></td>
									<td>
									<?php 
										if($v['state']==1){echo "<span class='btn btn-xs btn-info'>待支付</span> ";
										}elseif($v['state']==2){echo "<span class='btn btn-xs btn-success'>待发货</span> ";
										}elseif($v['state']==3){echo "<span class='btn btn-xs btn-warning'>待收货</span> ";
										}elseif($v['state']==4){echo "<span class='btn btn-xs btn-danger'>待评价</span> ";
										}elseif($v['state']==5){echo "<span class='btn btn-xs btn-primary'>完成</span>";}
									?>
									</td>
									<td>
										<a title="详情" href="<?php echo site_url('adminct/order/detail/id-'.$v['id']); ?>" class="btn btn-xs btn-primary">详情</a> 
									</td>
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
<?php echo template('admin/script');?>
<?php echo template('admin/footer');?>