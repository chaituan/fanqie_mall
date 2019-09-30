<?php echo template('admin/header');template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading font-bold">
					<span class="pull-right"><a href="<?php echo $index_url;?>"><i class="fa fa-arrow-circle-left fa-fw"></i> 返回</a></span> <i class="fa fa-plus fa-fw"></i> 详情
				</div>
				<div class="panel-body">
					<div class="form-horizontal">
						<h4>订单详情</h4>
						<div class="line line-dashed b-b line-lg pull-in"></div>
			            <div class="form-group">
			              <label class="col-sm-2 control-label">订单编号:</label>
			              <div class="col-sm-4"><p class="form-control-static"><?php echo $items['item']['order_no'];?></p></div>
			              <label class="col-sm-2 control-label">订单状态:</label>
			              <div class="col-sm-4"><p class="form-control-static">
			              			<?php 
										if($items['item']['state']==1){echo "<span class='btn btn-xs btn-info'>待支付</span> ";
										}elseif($items['item']['state']==2){echo "<span class='btn btn-xs btn-success'>待发货</span> ";
										}elseif($items['item']['state']==3){echo "<span class='btn btn-xs btn-warning'>待收货</span> ";
										}elseif($items['item']['state']==4){echo "<span class='btn btn-xs btn-danger'>待评价</span> ";
										}elseif($items['item']['state']==5){echo "<span class='btn btn-xs btn-primary'>完成</span>";}
									?>
			              </p></div>
			            </div>
			            <div class="form-group">
			              <label class="col-sm-2 control-label">下单时间:</label>
			              <div class="col-sm-4"><p class="form-control-static"><?php echo format_time($items['item']['addtime']);?></p></div>
			              <label class="col-sm-2 control-label">订单金额:</label>
			              <div class="col-sm-4"><p class="form-control-static"><?php echo $items['item']['price'];?></p></div>
			            </div>
			            <div class="form-group">
			              <label class="col-sm-2 control-label">快递公司:</label>
			              <div class="col-sm-4"><p class="form-control-static"><?php echo $items['item']['exp_company'];?></p></div>
			              <label class="col-sm-2 control-label">快递单号:</label>
			              <div class="col-sm-4"><p class="form-control-static"><?php echo $items['item']['exp_no'];?></p></div>
			            </div>
			            <div class="form-group">
			              <label class="col-sm-2 control-label">买家留言:</label>
			              <div class="col-sm-10"><p class="form-control-static"><?php echo $items['item']['message'];?></p></div>
			            </div>
			            
			            <h4>收货信息</h4>
						<div class="line line-dashed b-b line-lg pull-in"></div>
			            <div class="form-group">
			              <label class="col-sm-2 control-label">收货人姓名:</label>
			              <div class="col-sm-4"><p class="form-control-static"><?php echo $items['item']['name'];?></p></div>
			              <label class="col-sm-2 control-label">收货人电话:</label>
			              <div class="col-sm-4"><p class="form-control-static"><?php echo $items['item']['mobile'];?></p></div>
			            </div>
			            <div class="form-group">
			              <label class="col-sm-2 control-label">收货人地址:</label>
			              <div class="col-sm-10"><p class="form-control-static"><?php echo $items['item']['address'];?></p></div>
			            </div>
			            
						<div class="line line-dashed b-b line-lg pull-in"></div>
						<div class="table-responsive">
							<table class="table table-striped b-t b-light" style="margin-bottom: 0;">
								<thead>
									<tr>
										<th>序号</th>
										<th>商品标题</th>
										<th>商品规格</th>
										<th>单价</th>
										<th>数量</th>
									</tr>
								</thead>
								<tbody>
	                                <?php if (empty($items['child'])){ ?>
		                            <tr>
										<td class="empty-table-td"><?php echo $emptyRecord;?></td>
									</tr>
	                                <?php }else{ foreach ($items['child'] as $v){ ?>
	                                <tr>
										<td><?php echo $v['id'];?></td>
										<td><?php echo $v['title'];?></td>
										<td><?php echo $v['sku'];?></td>
										<td><?php echo $v['prices'];?></td>
										<td><?php echo $v['num'];?></td>
									</tr>
	                                <?php }}?>
	                            </tbody>
							</table>
						</div>
					</div>
					<?php if($items['item']['state']==2){?>
					<form class="form-horizontal" autocomplete="off" id="content_add_form">
						<div class="line line-dashed b-b line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label"> 快递公司</label>
							<div class="col-sm-10">
								<select name="data[exp_company]" class="form-control">
								<?php foreach ($exp as $v){?>
									<option value="<?php echo $v;?>"  <?php if($items['item']['exp_company']==$v)echo 'selected';?> ><?php echo $v;?></option>
								<?php }?>
								</select>
							</div>
						</div>
						<div class="line line-dashed b-b line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label"> 快递单号</label>
							<div class="col-sm-10">
								<input type="text" name="data[exp_no]" class="form-control" cname="快递单号" value="<?php echo $items['item']['exp_no'];?>" required>
							</div>
						</div>
						<div class="line line-dashed b-b line-lg pull-in"></div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="hidden" name="id" value="<?php echo $items['item']['id']?>">
								<a href="<?php echo site_url($edit_url)?>" class="btn btn-sm btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"content_add_form", "method":"post" ,"location":"<?php echo site_url($index_url)?>"}'>发货</a>
							</div>
						</div>
					</form>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo template('admin/script');?>
<?php echo template('admin/footer');?>