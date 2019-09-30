<?php echo template('admin/header');echo template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading font-bold">
					<span class="pull-right"> <a href="<?php echo $add_url;?>"><i class="fa fa-plus fa-fw"></i> 添加</a>&nbsp;&nbsp;&nbsp; <a href="<?php echo $index_url;?>"><i class="fa fa-arrow-circle-left fa-fw"></i> 返回</a>
					</span> <i class="fa fa-edit fa-fw"></i> 编辑
				</div>
				<div class="panel-body">
					<form class="form-horizontal" autocomplete="off" id="content_add_form">
						<div class="form-group">
							<label class="col-sm-2 control-label">菜单分组key</label>
							<div class="col-sm-10">
								<select name="data[groupkey]" data-toggle="select" id="menu-group-select" class="form-control select select-default">
                                <?php foreach ($menuGroups as $value){?>
                                <option value="<?php echo $value['tkey']?>" <?php if ($value['tkey']==$item['groupkey'])echo 'selected';?>><?php echo $value['name'];?></option>
                                <?php }?>
                            </select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">上级菜单</label>
							<div class="col-sm-10">
								<select name="data[pid]" data-toggle="select" id="pmenu-select" class="form-control select select-default">
									<option value="0">顶级菜单</option>
                                <?php foreach ($menuData as $value){?>
                                <option value="<?php echo $value['id'];?>" <?php if ($value['id']==$item['pid'])echo 'selected';?>><?php echo $value['name'];?></option>
                                <?php }?>
                            </select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">菜单名称</label>
							<div class="col-sm-10">
								<input type="text" name="data[name]" class="form-control" value="<?php echo $item['name'];?>" max-length="10" placeholder="菜单名称" required autofocus>
								<p class="help-block">长度在10以内，不区分中英文。</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">菜单URL</label>
							<div class="col-sm-10">
								<input type="text" name="data[url]" value="<?php echo $item['url'];?>" class="form-control" placeholder="菜单URL" required>
								<p class="help-block">长度在100以内。</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">排序数字</label>
							<div class="col-sm-10">
								<input type="text" name="data[sort_num]" value="<?php echo $item['sort_num'];?>" class="form-control" dtype="number" placeholder="排序数字" required>
								<p class="help-block">数字越小越靠前，三位数以内</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">是否显示</label>
							<div class="col-sm-10">
								<label class="i-switch m-t-xs m-r"> <input type="checkbox" name="data[ishow]" value="1" <?php if($item['ishow']==1)echo 'checked';?>><i></i>
								</label>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="hidden" name="id" value="<?php echo $item['id'];?>" /> <a href="<?php echo site_url('adminct/menu/edit')?>" class="btn btn-sm btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"content_add_form", "method":"post", "location":"<?php echo site_url('adminct/menu/index')?>"}'>保存修改</a>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</div>
<?php echo template('admin/script');?>
<script type="text/javascript">
$(function(){
	$('#menu-group-select').on('change', function() {
	    var key = $(this).val();
	    $('#pmenu-select').empty();
	    //加载一级分类
	    $.post('/adminct/menu/getTopMemnu', {groupkey:key}, function(res) {
	        if ( res.state == 'ok' ) {
	            var data = res.message;
	            $('#pmenu-select').append('<option value="0">顶级分类</option>');
	            for ( var i = 0; i < data.length; i++ ) {
	                $('#pmenu-select').append('<option value="'+data[i].id+'">'+data[i].name+'</option>');
	            }
	        }else{
	        	$('#pmenu-select').append('<option value="0">顶级分类</option>');
		    }
	    }, 'json');
	});
});
</script>

<?php echo template('admin/footer');?>
