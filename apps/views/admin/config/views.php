<?php echo template('admin/header');echo template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading font-bold">
					<i class="fa fa-edit fa-fw"></i> 配置
				</div>
				<div class="panel-body">
					<form class="form-horizontal" autocomplete="off" id="content_add_form">
					<?php foreach($items as $v) {if($v['imports'] == 'text') {?>
						<div class="form-group">
							<label class="col-sm-2 control-label"><?php echo $v['cname']?></label>
							<div class="col-sm-10">
								<input type="hidden" name="data[hids][<?php echo $v['id'];?>]" value="<?php echo $v['id'];?>"> <input type="text" name="data[<?php echo $v['id'];?>][val]" value="<?php echo $v['val'];?>" class="form-control" placeholder="<?php echo $v['cname']?>" required>
								<p class="help_block"><?php echo $v['bak']?></p>
							</div>
						</div>
						<div class="line line-dashed b-b line-lg pull-in"></div>
                    <?php }else{?>
                    	<div class="form-group">
							<label class="col-sm-2 control-label"><?php echo $v['cname']?></label>
							<div class="col-sm-10">
								<input type="hidden" name="data[hids][<?php echo $v['id'];?>]" value="<?php echo $v['id'];?>"> <label class="i-switch m-t-xs m-r"> <input type="checkbox" name="data[<?php echo $v['id'];?>][val]" value="1" <?php if($v['val']==1){ echo 'checked';}?>> <i></i>
								</label>
								<p class="help_block"><?php echo $v['bak']?></p>
							</div>
						</div>
						<div class="line line-dashed b-b line-lg pull-in"></div>
					<?php }}?>
                    <div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<a href="<?php echo site_url('adminct/config/quicksave')?>" class="btn btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"content_add_form", "method":"post", "location":""}'>保存修改</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo template('admin/script');?>
<?php echo template('admin/footer');?>
