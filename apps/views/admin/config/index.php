<?php echo template('admin/header');echo template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body animated fadeInRight">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-list-alt fa-fw"></i> 配置
				</div>
				<div class="table-responsive">
					<table class="table table-striped b-t b-light">
						<thead>
							<tr>
								<th>分组key</th>
								<th>变量</th>
								<th>变量名</th>
								<th>变量值</th>
								<th>输入</th>
								<th>说明</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
                                <?php if (empty($items)){ ?>
	                            <tr>
								<td class="empty-table-td text-center"><?php echo $emptyRecord;?></td>
							</tr>
                                <?php }else{foreach ($items as $key=>$value){ ?>
                                <tr>
								<td><?php echo $value['tkey'];?></td>
								<td><?php echo $value['cname'];?></td>
								<td><?php echo $value['key'];?></td>
								<td title="<?php echo $value['val'];?>"><?php echo str_cut($value['val'],40);?></td>
								<td><?php echo $value['imports'];?></td>
								<td><span data-toggle="popover" data-content="<?php echo $value['bak'];?>"><?php echo mb_substr($value['bak'],0,20);?></span></td>
								<td><a href="<?php echo site_url('adminct/config/edit/id-'.$value['id']); ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a> <a href="<?php echo site_url('adminct/config/delete/id-'.$value['id']); ?>" class="btn btn-xs btn-danger delone"><i class="fa fa-times"></i></a></td>
							</tr>
                                <?php }}?>
                                </tbody>
					</table>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-5 hidden-xs">
							<button type="button" class="btn btn-sm btn-primary m-b-xs btn-addon" data-toggle="modal" data-target=".add-config">
								<i class="fa fa-plus"></i> 添加配置信息
							</button>
						</div>
					</div>
				</footer>
			</div>
		</div>
	</div>
</div>
<div aria-hidden="false" aria-labelledby="myLargeModalLabel" role="dialog" tabindex="-1" class="modal fade add-config">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button aria-label="Close" data-dismiss="modal" class="close" type="button">
					<span aria-hidden="true">×</span>
				</button>
				<h4 id="myLargeModalLabel" class="modal-title">添加配置信息</h4>
			</div>
			<div class="modal-body">
				<form id="config-add-form">
					<div class="form-group">
						<label>分组</label> <select class="form-control" name="data[tkey]">
                                        <?php foreach ($__menuGroups as $v){?>
											<option value="<?php echo $v['tkey'];?>"><?php echo $v['name'];?></option>
										<?php }?>
										</select>
					</div>
					<div class="form-group">
						<label>变量</label> <input type="text" class="form-control" name="data[cname]" max-length="30" placeholder="变量" required>
					</div>
					<div class="form-group">
						<label>变量名</label> <input type="text" class="form-control" name="data[key]" max-length="30" placeholder="变量名" required>
					</div>
					<div class="form-group">
						<label>变量值</label>
						<textarea class="form-control" name="data[val]" placeholder="变量值" required></textarea>
					</div>
					<div class="form-group">
						<label>输入</label> <select class="form-control" name="data[imports]">
							<option value="text">文本框</option>
							<option value="radio">单选框</option>
						</select>
					</div>
					<div class="form-group">
						<label>变量说明</label>
						<textarea class="form-control" name="data[bak]" max-length="100" placeholder="变量备注"></textarea>
					</div>
					<a href="<?php echo site_url('adminct/config/add')?>" class="btn btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"config-add-form", "method":"post", "location":"reload"}'>保存修改</a>
				</form>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<?php echo template('admin/script');?>
<script>
    //初始化弹出框
    $('[data-toggle="popover"]').popover({trigger:'hover', placement:'top', html:true});
</script>
<?php echo template('admin/footer');?>