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
						<form class="form-inline search-form" action="" method="get">
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
									<th>用户ID</th>
									<th>用户名</th>
									<th>公司名字</th>
									<th>店铺名字</th>
									<th>头像</th>
									<th>使用状态</th>
									<th>最后登录时间</th>
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
									<td><?php echo $v['id'];?></td>
									<td><?php echo $v['username'];?></td>
									<td><?php echo $v['company'];?></td>
									<td><?php echo $v['shop_name'];?></td>
									<td><a class="thumb" data-src="<?php echo $v['thumb'];?>">查看</a></td>
									<td><?php echo $v['state']?"正常使用":"已禁用";?></td>
									<td><?php echo $v['last_login_time']?format_time($v['last_login_time']):'--';?></td>
									<td>
									<a href="<?php echo site_url('adminct/shop/enable/id-'.$v['id']); ?>" class="btn btn-xs btn-primary delone">启用</a>
									<a href="<?php echo site_url('adminct/shop/disable/id-'.$v['id']); ?>" class="btn btn-xs btn-danger delone">禁用</a>
									<a href="<?php echo site_url('adminct/shop/edit/id-'.$v['id']); ?>" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-pencil"></i></a>
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
<script type="text/javascript">
$(function(){
	$('.thumb').click(function(){
		layer.photos({
			  photos: {
			    "data": [{
			      	"src": $(this).data('src'),
			    }]
			  },
			  anim: 1,
			  closeBtn:1,
			  shadeClose:false,
			});
	});
});

</script>
<?php echo template('admin/footer');?>