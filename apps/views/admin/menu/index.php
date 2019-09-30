<?php echo template('admin/header');echo template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body animated fadeIn">
		<div class="bg-light lter b-b wrapper-md">
			<h1 class="m-n font-thin h3">
				<i class="fa fa-navicon i-sm m-r-sm"></i> 后台菜单配置
			</h1>
		</div>
		<div class="wrapper-md">
			<!-- content form start -->
			<form id="J_ListForm" name="contentListForm">

				<div class="tab-container">
					<ul class="nav nav-tabs">
	                    <?php foreach ($menuGroups as $key=>$val){?>
	                    	<li class="<?php if($key=='system')echo 'active';?>"><a data-toggle="tab" data-target="<?php echo "#tab_$key";?>"><?php echo $val['name'];?></a></li>
	                    <?php }?>
	                </ul>
					<div class="tab-content">
	                    <?php foreach ($menuGroups as $key=>$gval){?>
	                    <div class="tab-pane <?php if($key=='system')echo 'active';?>" id="<?php echo "tab_$key";?>">
							<table class="table table-bordered table-hover table-condensed">
								<thead>
									<tr>
										<th>ID</th>
										<th>菜单名称</th>
										<th>URL</th>
										<th>排序数字</th>
										<th>是否显示</th>
										<th>添加时间</th>
										<th>操作</th>
									</tr>
								</thead>

								<tbody>
	                            <?php if (empty($items[$key])){?>
	                            <tr>
										<td class="empty-table-td"><?php echo $emptyRecord;?></td>
									</tr>
	                            <?php }?>
	
								<?php foreach ($items[$key] as $value){ ?>
	                            <tr id="items_<?php echo $value['id']; ?>">
										<td>
	                                   <?php echo $value['id']; ?>
	                                    <input type="hidden" name="hids[<?php echo $value['id']; ?>]" value="<?php echo $value['id']; ?>" />
										</td>
										<td><input type="text" name="data[<?php echo $value['id']; ?>][name]" value="<?php echo $value['name']; ?>" class="form-control input-sm" /></td>

										<td><input type="text" name="data[<?php echo $value['id']; ?>][url]" value="<?php echo $value['url']; ?>" class="form-control input-sm" /></td>
										<td><input type="text" name="data[<?php echo $value['id']; ?>][sort_num]" value="<?php echo $value['sort_num']; ?>" class="form-control input-sm" /></td>
										<td><label class="i-switch m-t-xs m-r"> <input type="checkbox" name="data[<?php echo $value['id']; ?>][ishow]" value="1" <?php if($value['ishow']==1){ echo 'checked';}?>> <i></i>
										</label></td>
										<td><?php echo date('Y-m-d',$value['add_time']); ?></td>
										<td><a href="<?php echo site_url('adminct/menu/add/pid-'.$value['id'])?>" data-toggle="tooltip" title="添加子菜单" class="btn btn-xs btn-info"><i class="fa fa-plus"></i></a> <a href="<?php echo site_url('adminct/menu/edit/id-'.$value['id'])?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a> <a href="<?php echo site_url('adminct/menu/delete/id-'.$value['id'])?>" class="btn btn-xs btn-danger delone"> <i class="fa fa-times"></i></a></td>
									</tr>

									<!-- 二级菜单 -->
	                            <?php foreach ($subitems[$value['id']] as $val){?>
	                            <tr id="items_<?php echo $val['id']; ?>" class="items_<?php echo $val['id']; ?>">
										<td>
	                                    <?php echo $val['id']; ?>
	                                    <input type="hidden" name="hids[<?php echo $val['id']; ?>]" value="<?php echo $val['id']; ?>" />
										</td>
										<td style="padding-left: 30px;"><input type="hidden" name="hids[<?php echo $val['id']; ?>]" value="<?php echo $val['id']; ?>" /> <input type="text" name="data[<?php echo $val['id']; ?>][name]" value="<?php echo $val['name']; ?>" class="form-control input-sm" /></td>

										<td><input type="text" name="data[<?php echo $val['id']; ?>][url]" value="<?php echo $val['url']; ?>" class="form-control input-sm" /></td>
										<td><input type="text" name="data[<?php echo $val['id']; ?>][sort_num]" value="<?php echo $val['sort_num']; ?>" class="form-control input-sm" /></td>
										<td><label class="i-switch m-t-xs m-r"> <input type="checkbox" name="data[<?php echo $val['id']; ?>][ishow]" value="1" <?php if($val['ishow']==1){ echo 'checked';}?>> <i></i>
										</label></td>
										<td><?php echo date('Y-m-d',$val['add_time']); ?></td>

										<td><a href="<?php echo site_url('adminct/menu/edit/id-'.$val['id'])?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a> <a href="<?php echo site_url('adminct/menu/delete/id-'.$val['id'])?>" class="btn btn-xs btn-danger delone"> <i class="fa fa-times"></i></a></td>
									</tr>
	                            <?php }}?>
	                            </tbody>
							</table>
						</div>
	                    <?php }?>
	                    <div class="opt_box">
							<a href="<?php echo site_url('adminct/menu/add')?>" class="btn btn-sm btn-primary m-b-xs btn-addon"><i class="fa fa-plus"></i> 添加菜单</a> <a href="<?php echo site_url('adminct/menu/quicksave');?>" class="ajaxproxy btn btn-sm btn-success m-b-xs btn-addon" data-loading-text="正在保存……" proxy='{"method":"post", "formId":"J_ListForm", "location":"reload"}'> <i class="fa fa-save"></i> 快速保存
							</a>
						</div>
					</div>
				</div>
			</form>
			<!-- form END -->
		</div>
	</div>
</div>
<?php echo template('admin/script');?>
<?php echo template('admin/footer');?>