<?php echo template('admin/header');echo template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body animated fadeInRight">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="pull-right"><a href="<?php echo $add_url;?>"><i class="fa fa-plus fa-fw"></i> 添加</a></span> <i class="fa fa-list-alt fa-fw"></i> 列表
				</div>
				<div class="row wrapper">
					<div class="col-sm-12 m-b-xs">
						<form class="form-inline search-form" action="/adminct/news/index/" method="get">
							<div class="form-group">
								<select name="cid" data-toggle="select" class="input-sm form-control w-sm inline v-middle">
									<option value="0">选择分类</option>
		              			<?php foreach ($cat as $v){?>
		              			<option value="<?php echo $v['id'];?>" <?php if(isset($cid)){if($cid==$v['id'])echo 'selected';}?>> <?php echo str_repeat('├',$v['level']).' '.$v['catname'];?></option>
		              			<?php }?>
			                </select>
							</div>
							<div class="form-group">
								<div class="input-group">
									<input type="text" name="name" class="form-control input-sm" value="<?php echo isset($name)?$name:"";?>" placeholder="请输入标题" /> <span class="input-group-btn">
										<button class="btn btn-sm btn-default" type="submit">Go!</button>
									</span>
								</div>
							</div>
						</form>
					</div>
				</div>
				<form id="J_ListForm">
					<div class="table-responsive">
						<table class="table table-striped b-t b-light" style="margin-bottom: 0;">
							<thead>
								<tr>
									<th style="width: 20px;"><label class="i-checks m-b-none" id="check-all"> <input type="checkbox"><i></i>
									</label></th>
									<th>标题</th>
									<th>图片</th>
									<th>访问量</th>
									<th>分类</th>
									<th>位置</th>
									<th>添加时间</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
						<?php if (empty($items)){ ?>
						    <tr>
									<td class="empty-table-td text-center"><?php echo $emptyRecord;?></td>
								</tr>
						    <?php }else{ foreach ($items as $v){?>
							<tr id="list_<?php echo $v['id']?>">
									<td><label class="i-checks m-b-none"><input type="checkbox" name="ids[]" value="<?php echo $v['id']?>"><i></i></label></td>
									<td title="<?php echo $v['title'];?>"><?php echo str_cut($v['title'], 20);?></td>
									<td><img alt="" src="<?php echo $v['thumb'];?>" style="height: 25px;"></td>
									<td><?php echo $v['hits'];?></td>
									<td><?php echo $v['catname']?$v['catname']:"无";?></td>
									<td><?php if($v['state']==1){echo '热点推荐';}elseif($v['state']==2){echo '首页推荐';}else{echo '无';}?></td>
									<td><?php echo format_time($v['addtime']);?></td>
									<td><a href="<?php echo site_url('adminct/news/edit/id-'.$v['id']); ?>" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-pencil"></i></a> <a href="<?php echo site_url('adminct/news/delete/id-'.$v['id']); ?>" class="btn btn-xs btn-danger delone"><i class="fa fa-fw fa-times"></i></a></td>
								</tr>
						<?php }}?>
	                  </tbody>
						</table>
					</div>
				</form>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-5 hidden-xs">
							<a href="<?php echo site_url('adminct/news/deletes')?>" class="btn btn-sm btn-danger m-b-xs btn-addon ajaxproxy" data-loading-text="正在删除" proxy='{"formId":"J_ListForm", "method":"post", "location":"#","tips":"ok","callBack":"list_deletes(data)"}'> <i class="fa fa-trash-o"></i> 删除选中
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
<!-- /content -->

<?php echo template('admin/script');?>
<?php echo template('admin/footer');?>