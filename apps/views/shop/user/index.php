<?php echo template('admin/header');echo template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="pull-right"><a href="<?php echo $add_url;?>"><i class="fa fa-plus fa-fw"></i> 添加</a></span> <i class="fa fa-list-alt fa-fw"></i> 列表
				</div>
				<div class="row wrapper">
					<div class="col-sm-12 m-b-xs">
						<form class="form-inline search-form" action="/adminct/news/index/" method="get">
							<div class="form-group">
								<div class="input-group">
									<input type="text" name="name" class="form-control input-sm" value="<?php echo isset($name)?$name:"";?>" placeholder="请输手机号" /> <span class="input-group-btn">
										<button class="btn btn-sm btn-default" type="submit">Go!</button>
									</span>
								</div>
							</div>
						</form>
					</div>
				</div>
				<form id="J_ListForm" role="form" method="post">
					<div class="table-responsive">
						<table class="table table-striped b-t b-light" style="margin-bottom: 0;">
							<thead>
								<tr>
									<th style="width: 20px;"><label class="i-checks m-b-none" id="check-all"> <input type="checkbox"><i></i>
									</label></th>
									<th>昵称</th>
									<th>手机号码</th>
									<th>注册时间</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
                                <?php if (empty($items)){ ?>
	                            <tr>
									<td class="empty-table-td"><?php echo $emptyRecord;?></td>
								</tr>
	                            <?php }else{?>

                                <?php foreach ($items as $key=>$v){ ?>
                                <tr id="list_<?php echo $v['id']?>">
									<td><label class="i-checks m-b-none"><input type="checkbox" name="ids[]" value="<?php echo $v['id']?>"><i></i></label></td>
									<td><?php echo $v['nickname'];?></td>
									<td><?php echo $v['username'];?></td>
									<td><?php echo format_time($v['addtime']);?></td>
									<td><a href="<?php echo site_url('adminct/user/delete/id-'.$key); ?>" class="btn btn-xs btn-danger delone"><i class="fa fa-fw fa-times"></i></a></td>
								</tr>
                                <?php }}?>
                                </tbody>
						</table>
					</div>
				</form>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-5 hidden-xs">
							<a href="<?php echo site_url('adminct/user/deletes')?>" class="btn btn-sm btn-danger ajaxproxy" data-loading-text="正在删除" proxy='{"formId":"J_ListForm", "method":"post", "location":"#","tips":"ok","callBack":"list_deletes(data)"}'> <i class="glyphicon glyphicon-remove"></i> 删除选中
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